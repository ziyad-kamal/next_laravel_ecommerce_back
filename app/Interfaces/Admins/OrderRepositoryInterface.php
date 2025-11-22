<?php

namespace App\Interfaces\Admins;

use App\Models\{Order};
use Illuminate\Contracts\Pagination\Paginator;

interface OrderRepositoryInterface
{
    public function index(): Paginator;

    public function show(Order $order): mixed;

    public function delete(Order $order): void;
}
