<?php

namespace App\Repositories\Admins;

use App\Enums\{OrderState};
use App\Http\Resources\OrderResource;
use App\Interfaces\Admins\{DashboardRepositoryInterface};
use App\Models\{Category, Item, Order, User};
use App\Traits\GetChangePercent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, DB};

class DashboardRepository implements DashboardRepositoryInterface
{
    use GetChangePercent;

    // MARK: index
    public function dashboardIndex(Request $request): array
    {
        $userId       = $request->user()->id;
        $defaultLang  = Cache::get("defaultLang{$userId}", 'en');
        // $dashboardData = Cache::remember("dashboard_data_{$defaultLang}", now()->addHours(3), function () use ($request) {
        $currentPeriodStart   = now()->subMonths($request->months);
        $previousPeriodStart  = now()->subMonths($request->months * 2);
        // Total Sales
        $salesStats = Order::query()
            ->join('order_item', 'orders.id', '=', 'order_item.order_id')
            ->join('item_infos', 'order_item.item_id', '=', 'item_infos.item_id')
            ->where('state', OrderState::Delivered)
            ->selectRaw('
                SUM(CASE WHEN orders.date_of_delivery >= ? THEN item_infos.price * order_item.quantity ELSE 0 END) as current_sales,
                SUM(CASE WHEN orders.date_of_delivery BETWEEN ? AND ? THEN item_infos.price * order_item.quantity ELSE 0 END) as previous_sales
            ', [$currentPeriodStart, $previousPeriodStart, $currentPeriodStart])
            ->first();

        $currentSales   = $salesStats->current_sales;
        $previousSales  = $salesStats->previous_sales;
        $salesChange    = $this->getChangePercent($currentSales, $previousSales);

        // Orders Count
        $orderStats = Order::selectRaw('
                COUNT(CASE WHEN created_at >= ? THEN 1 END) as current_orders,
                COUNT(CASE WHEN created_at BETWEEN ? AND ? THEN 1 END) as previous_orders
                ', [$currentPeriodStart, $previousPeriodStart, $currentPeriodStart])
            ->first();

        $currentOrders  = $orderStats->current_orders;
        $previousOrders = $orderStats->previous_orders;
        $ordersChange   = $this->getChangePercent($currentOrders, $previousOrders);

        // users Count
        $userStats = User::query()
            ->selectRaw('
                    COUNT(CASE WHEN created_at >= ? THEN 1 END) as current_users,
                    COUNT(CASE WHEN created_at BETWEEN ? AND ? THEN 1 END) as previous_users
                ')
            ->setBindings([$currentPeriodStart, $previousPeriodStart, $currentPeriodStart])
            ->first();

        $currentUsers   = $userStats->current_users;
        $previousUsers  = $userStats->previous_users;
        $usersChange    = $this->getChangePercent($currentUsers, $previousUsers);

        // items Count
        $itemStats = Item::query()
            ->selectRaw('
                    COUNT(CASE WHEN created_at >= ? THEN 1 END) as current_items,
                    COUNT(CASE WHEN created_at BETWEEN ? AND ? THEN 1 END) as previous_items
                ')
            ->setBindings([$currentPeriodStart, $previousPeriodStart, $currentPeriodStart])
            ->first();

        $currentItems   = $itemStats->current_items;
        $previousItems  = $itemStats->previous_items;
        $itemsChange    = $this->getChangePercent($currentItems, $previousItems);

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
            ->join('items', 'categories.trans_of', '=', 'items.category_id')
            ->join('item_infos', 'items.id', '=', 'item_infos.item_id')
            ->join('order_item', 'items.id', '=', 'order_item.item_id')
            ->join('orders', 'order_item.order_id', '=', 'orders.id')
            ->select(
                'categories.name',
                DB::raw('SUM(item_infos.price * order_item.quantity) as value')
            )
            ->where('orders.date_of_delivery', '>=', $currentPeriodStart)
            ->where(['orders.state' => OrderState::Delivered, 'categories.trans_lang' => $defaultLang])
            ->groupBy('categories.trans_of')
            ->orderByDesc('value')
            ->limit(3)
            ->get();

        $topCategoriesTotal         = $categoryData->sum('value');
        $otherCategoriesValue       = $salesStats->current_sales  - $topCategoriesTotal;

        if ($otherCategoriesValue > 0) {
            $categoryData->push((object) [
                'name'  => 'Other',
                'value' => $otherCategoriesValue,
            ]);
        }

        $trafficData = DB::table('visits')
            ->selectRaw('DAYNAME(created_at) as day')
            ->selectRaw('COUNT(*) as visits')
            ->selectRaw('SUM(CASE WHEN converted = 1 THEN 1 ELSE 0 END) as signup')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'), 'day')
            ->orderBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

        $recentOrders = Order::query()
            ->selection()
            ->latest()
            ->limit(10)
            ->get();

        $data = [
            'stats' => [
                [
                    'title'         => 'Total sales',
                    'value'         => '$'.$salesStats->current_sales,
                    'change'        => $salesChange,
                ],
                [
                    'title'        => 'Orders',
                    'value'        => $currentOrders,
                    'change'       => $ordersChange,
                ],
                [
                    'title'        => 'Users',
                    'value'        => $currentUsers,
                    'change'       => $usersChange,
                ],
                [
                    'title'        => 'Items',
                    'value'        => $currentItems,
                    'change'       => $itemsChange,
                ],
            ],
            'sales_data'    => $salesData,
            'category_data' => $categoryData,
            'traffic_data'  => $trafficData,
            'recent_orders' => OrderResource::collection($recentOrders),
        ];

        return $data;
        // });

        return $dashboardData;
    }
}
