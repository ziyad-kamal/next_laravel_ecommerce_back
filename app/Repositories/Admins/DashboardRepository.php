<?php

namespace App\Repositories\Admins;

use App\Enums\TransactionType;
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
        $totalRevenue       = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) {
                $query->where('type', TransactionType::Buy);
            })
            ->sum('total_amount');

        $RevenueChange      = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) use ($date) {
                $query->where('type', TransactionType::Buy)->where('transactions.created_at', '>=', $date);
            })
            ->sum('total_amount');

        $revenueChangePercent = 0;
        if ($totalRevenue != 0) {
            $revenueChangePercent = round($RevenueChange / $totalRevenue * 100, 2);
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
            $itemsChangePercent = round($usersStats->itemsCountChange / $totalItemsCount * 100, 2);
        }
        $months      = $request->months;
        $revenueData = Order::selectRaw("
                DATE_FORMAT(created_at, '%b') as name,
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                SUM(total_amount) as revenue,
                COUNT(*) as orders
            ")
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy(DB::raw("YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')"))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $categoryData = DB::table('categories')
            ->join('items', 'categories.id', '=', 'items.category_id')
            ->join('item_infos', 'items.id', '=', 'item_infos.item_id')
            ->join('order_item', 'items.id', '=', 'order_item.item_id')
            ->join('orders', 'order_item.order_id', '=', 'orders.id')
            ->join('transactions', 'orders.id', '=', 'transactions.order_id')
            ->select(
                'categories.name',
                DB::raw('SUM(item_infos.price) as value')
            )
            ->where('transactions.type', TransactionType::Buy)
            ->groupBy('categories.name')
            ->orderByDesc('value')
            ->limit(5)
            ->get();

        return [
            'total_revenue'                       => $totalRevenue,
            'total_revenue_change_percent'        => $revenueChangePercent,
            'orders_count'                        => $totalOrdersCount,
            'orders_count_change'                 => $ordersChangePercent,
            'user_count'                          => $totalUsersCount,
            'user_count_change'                   => $usersChangePercent,
            'items_count'                         => $totalItemsCount,
            'items_count_change'                  => $itemsChangePercent,
            'revenue_data'                        => $revenueData,
        ];
    }
}
