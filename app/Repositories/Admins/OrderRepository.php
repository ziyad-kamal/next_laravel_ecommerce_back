<?php

namespace App\Repositories\Admins;

use App\Interfaces\Admins\{OrderRepositoryInterface};
use App\Models\{Order};
use Illuminate\Contracts\Pagination\Paginator;

class OrderRepository implements OrderRepositoryInterface
{
    // MARK: index
    public function index(): Paginator
    {
        $keyToSort   = $request->keyToSort   ?? 'created_at';
        $direction   = $request->direction   ?? 'desc';

        return Order::query()
            ->with(['user'])
            ->orderBy($keyToSort, $direction)
            ->paginate(10);
    }

    // MARK: show
    public function show(Order $order): mixed
    {
        return Order::query()
            ->where('id', $order->id)
            ->with(['user', 'items'])
            ->get();

    }

    // MARK: delete
    public function delete(Order $order): void
    {
        $order->delete();
    }
}
