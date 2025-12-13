<?php

namespace App\Repositories\Admins;

use App\Enums\TransactionType;
use App\Interfaces\Admins\{DashboardRepositoryInterface};
use App\Models\{Item, Order, User};
use Illuminate\Http\Request;

class DashboardRepository implements DashboardRepositoryInterface
{
    // MARK: index
    public function dashboardIndex(Request $request): array
    {
        $days               = $request->days;
        $totalRevenue       = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) {
                $query->where('type', TransactionType::Buy);
            })
            ->sum('total_amount');

        $totalRevenueBefore       = Order::query()
            ->with('transaction')
            ->whereHas('transaction', function ($query) use ($days) {
                $query->where('type', TransactionType::Buy)->where('transactions.created_at', '<', now()->subDays($days));
            })
            ->sum('total_amount');

        $totalRevenueChange = $totalRevenue - $totalRevenueBefore;

        $ordersCount              = Order::count();
        $ordersCountBefore        = Order::where('created_at', now()->subDays($days))->count();
        $totalOrdersChange        = $ordersCount - $ordersCountBefore;

        $usersCount               = User::count();
        $usersCountBefore         = User::where('created_at', now()->subDays($days))->count();
        $totalUsersChange         = $usersCount - $usersCountBefore;

        $itemsCount               = Item::count();
        $itemsCountBefore         = Item::where('created_at', now()->subDays($days))->count();
        $totalItemsChange         = $itemsCount - $itemsCountBefore;

        return [
            'total_revenue'                       => $totalRevenue,
            'total_revenue_change'                => $totalRevenueChange,
            'orders_count'                        => $ordersCount,
            'orders_count_change'                 => $totalOrdersChange,
            'user_count'                          => $usersCount,
            'user_count_change'                   => $totalUsersChange,
            'items_count'                         => $itemsCount,
            'items_count_change'                  => $totalItemsChange,
        ];
    }
}
