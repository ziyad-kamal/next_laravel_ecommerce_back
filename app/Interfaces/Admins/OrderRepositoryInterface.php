<?php

namespace App\Interfaces\Admins;

use App\Http\Requests\OrderRequest;
use App\Models\{Order};
use Illuminate\Contracts\Pagination\Paginator;

interface OrderRepositoryInterface
{
    public function orderIndex(OrderRequest $request): Paginator;

    public function orderShow(Order $order): mixed;

    public function orderUpdate(Order $order, OrderRequest $request): void;

    public function orderDelivery(Order $order): void;

    public function orderRefund(Order $order): void;

    public function orderDelete(Order $order): void;
}
