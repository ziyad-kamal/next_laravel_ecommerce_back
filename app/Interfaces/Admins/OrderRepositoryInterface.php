<?php

namespace App\Interfaces\Admins;

use App\Http\Requests\{OrderRequest};
use App\Models\{Order};
use Illuminate\Contracts\Pagination\Paginator;

interface OrderRepositoryInterface
{
    public function index(): Paginator;

    public function store(OrderRequest $request): void;

    public function show(Order $order): mixed;

    public function update(OrderRequest $request, Order $order): void;

    public function delete(Order $order): void;
}
