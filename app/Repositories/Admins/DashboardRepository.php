<?php

namespace App\Repositories\Admins;

use App\Enums\{OrderState, TransactionType};
use App\Interfaces\Admins\{DashboardRepositoryInterface};
use App\Models\{Item, Order, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    // MARK: index
    public function dashboardIndex(Request $request): array
    {
        $date               = now()->subDays($request->days);
        $totalSales         = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) {
                $query->where('type', TransactionType::Buy);
            })
            ->sum('total_amount');

        $salesChange      = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) use ($date) {
                $query->where('type', TransactionType::Buy)->where('transactions.created_at', '>=', $date);
            })
            ->sum('total_amount');

        $salesChangePercent = 0;
        if ($totalSales != 0) {
            $salesChangePercent = round($salesChange / $totalSales * 100, 2);
        }

        $ordersStats = Order::selectRaw('
                COUNT(*) as total_count,
                SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as ordersCountChange
            ', [$date])
            ->first();

        $ordersChangePercent      = 0;
        $totalOrdersCount         = $ordersStats->total_count;
        if ($totalOrdersCount != 0) {
            $ordersChangePercent = round($ordersStats->ordersCountChange / $totalOrdersCount * 100, 2);
        }

        $usersStats = User::selectRaw('
                COUNT(*) as total_count,
                SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as usersCountChange
            ', [$date])
            ->first();

        $usersChangePercent      = 0;
        $totalUsersCount         = $usersStats->total_count;
        if ($totalUsersCount != 0) {
            $usersChangePercent = round($usersStats->usersCountChange / $totalUsersCount * 100, 2);
        }

        $itemsStats = Item::selectRaw('
                COUNT(*) as total_count,
                SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as itemsCountChange
            ', [$date])
            ->first();

        $itemsChangePercent      = 0;
        $totalItemsCount         = $itemsStats->total_count;
        if ($totalItemsCount != 0) {
            $itemsChangePercent = round($itemsStats->itemsCountChange / $totalItemsCount * 100, 2);
        }

        $months      = $request->months;
        $salesData   = Order::selectRaw("
                DATE_FORMAT(created_at, '%b') as name,
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                SUM(total_amount) as sales,
                COUNT(*) as orders
            ")
            ->where('created_at', '>=', now()->subMonths($months))
            ->where('state', OrderState::Delivered)
            ->groupBy(DB::raw("YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')"))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $categoryData = DB::table('categories')
            ->join('items', 'categories.id', '=', 'items.category_id')
            ->join('item_infos', 'items.id', '=', 'item_infos.item_id')
            ->join('order_item', 'items.id', '=', 'order_item.item_id')
            ->join('orders', 'order_item.order_id', '=', 'orders.id')
            ->select(
                'categories.name',
                DB::raw('SUM(item_infos.price) as value')
            )
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
                    'title'                      => 'Total sales',
                    'value'                      => $totalSales,
                    'change'                     => $salesChangePercent,
                ],
                [
                    'title'        => 'Orders',
                    'value'        => $totalOrdersCount,
                    'change'       => $ordersChangePercent,
                ],
                [
                    'title'        => 'users',
                    'value'        => $totalUsersCount,
                    'change'       => $usersChangePercent,
                ],
                [
                    'title'        => 'items',
                    'value'        => $totalItemsCount,
                    'change'       => $itemsChangePercent,
                ],
            ],
            'sales_data'    => $salesData,
            'category_data' => $categoryData,
            'traffic_data'  => $trafficData,
        ];
    }
}
