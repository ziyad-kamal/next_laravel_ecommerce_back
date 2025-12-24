<?php

namespace App\Repositories\Admins;

use App\Enums\{OrderState};
use App\Interfaces\Admins\{DashboardRepositoryInterface};
use App\Models\{Category, Item, Order, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    // MARK: index
    public function dashboardIndex(Request $request): array
    {
        $currentPeriodStart   = now()->subMonths($request->months);
        $previousPeriodStart  = now()->subMonths($request->months * 2);

        // Total Sales
        $totalSales         = Order::query()
            ->with('transaction')
            ->whereHas('transaction')
            ->sum('total_amount');

        $currentSales         = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) use ($currentPeriodStart) {
                $query->where('created_at', '>=', $currentPeriodStart);
            })
            ->sum('total_amount');

        $previousSales = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) use ($currentPeriodStart, $previousPeriodStart) {
                $query->whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart]);
            })
            ->sum('total_amount');

        $salesChange = $previousSales > 0
            ? (($currentSales - $previousSales) / $previousSales) * 100
            : 0;

        // Orders Count
        $currentOrders  = Order::where('created_at', '>=', $currentPeriodStart)->count();
        $previousOrders = Order::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();
        $ordersChange   = $previousOrders > 0
            ? (($currentOrders - $previousOrders) / $previousOrders) * 100
            : 0;

        // Customers Count
        $currentUsers  = User::where('created_at', '>=', $currentPeriodStart)->count();
        $previousUsers = User::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();
        $usersChange   = $previousUsers > 0
            ? (($currentUsers - $previousUsers) / $previousUsers) * 100
            : 0;

        // Products Count
        $currentItems  = Item::where('created_at', '>=', $currentPeriodStart)->count();
        $previousItems = Item::whereBetween('created_at', [$previousPeriodStart, $currentPeriodStart])->count();
        $itemsChange   = $previousItems > 0
            ? (($currentItems - $previousItems) / $previousItems) * 100
            : 0;

        $salesData   = Order::selectRaw("
                DATE_FORMAT(created_at, '%b') as name,
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                SUM(total_amount) as sales,
                COUNT(*) as orders
            ")
            ->where('created_at', '>=', $currentPeriodStart)
            ->where('state', OrderState::Delivered)
            ->groupBy(DB::raw("YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')"))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $categoryData = Category::query()
            ->join('items', 'categories.id', '=', 'items.category_id')
            ->join('item_infos', 'items.id', '=', 'item_infos.item_id')
            ->join('order_item', 'items.id', '=', 'order_item.item_id')
            ->join('orders', 'order_item.order_id', '=', 'orders.id')
            ->select(
                'categories.name',
                DB::raw('SUM(item_infos.price) as value')
            )
            ->where('orders.created_at', '>=', $currentPeriodStart)
            ->where('orders.state', OrderState::Delivered)
            ->groupBy('categories.name')
            ->orderByDesc('value')
            ->limit(5)
            ->get();

        $trafficData = DB::table('visits')
            ->selectRaw('DAYNAME(created_at) as day')
            ->selectRaw('COUNT(*) as visits')
            ->selectRaw('SUM(CASE WHEN converted = 1 THEN 1 ELSE 0 END) as conversions')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'), 'day')
            ->orderBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

        return [
            'stats' => [
                [
                    'title'         => 'Total sales',
                    'value'         => '$'.$totalSales,
                    'change'        => round($salesChange, 2),
                ],
                [
                    'title'        => 'Orders',
                    'value'        => $currentOrders,
                    'change'       => round($ordersChange, 2),
                ],
                [
                    'title'        => 'Users',
                    'value'        => $currentUsers,
                    'change'       => round($usersChange, 2),
                ],
                [
                    'title'        => 'Items',
                    'value'        => $currentItems,
                    'change'       => round($itemsChange, 2),
                ],
            ],
            'sales_data'    => $salesData,
            'category_data' => $categoryData,
            'traffic_data'  => $trafficData,
        ];
    }
}
