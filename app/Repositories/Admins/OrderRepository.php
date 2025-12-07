<?php

namespace App\Repositories\Admins;

use App\Enums\{OrderState, TransactionType};
use App\Http\Requests\OrderRequest;
use App\Interfaces\Admins\{OrderRepositoryInterface};
use App\Models\{Order, Transactions};
use Illuminate\Contracts\Pagination\Paginator;

class OrderRepository implements OrderRepositoryInterface
{
    // MARK: index
    public function orderIndex(OrderRequest $request): Paginator
    {
        $keyToSort   = $request->keyToSort ? $request->keyToSort : 'created_at';
        $direction   = $request->direction ? $request->direction : 'desc';

        $orders = Order::with('user');

        $dateOfDelivery = $request->date_of_delivery;
        if ($dateOfDelivery) {
            $orders = $orders->whereDate('date_of_delivery', $dateOfDelivery);
        }

        $userName = $request->user_name;
        if ($userName) {
            if ($userName) {
                $orders = $orders->whereHas('user', function ($query) use ($userName) {
                    $query->where('name', 'LIKE', "{$userName}%");
                });
            }
        }

        $state = $request->state;
        if ($state) {
            $orders = $orders->where('state', $state);
        }

        return $orders
            ->orderBy($keyToSort, $direction)
            ->paginate(10);
    }

    // MARK: show
    public function orderShow(Order $order): mixed
    {
        return Order::query()
            ->where('id', $order->id)
            ->with(['user', 'items', 'items.item_files', 'user.user_infos'])
            ->first();
    }

    // MARK: update
    public function orderUpdate(Order $order, OrderRequest $request): void
    {
        $order->update(['state' => $request->state]);
    }

    // MARK: Delivery
    public function orderDelivery(Order $order): void
    {
        $order->update(['state' => OrderState::Delivered]);

        Transactions::create([
            'bank_trans_id'       => null,
            'order_id'            => $order->id,
            'type'                => TransactionType::Buy,
        ]);
    }

    // MARK: Refund
    public function orderRefund(Order $order): void
    {
        $order->update(['state' => OrderState::Refunded]);

        Transactions::where('order_id', $order->id)->update(['type'  => TransactionType::Refund]);
    }

    // MARK: delete
    public function orderDelete(Order $order): void
    {
        $order->delete();
    }
}
