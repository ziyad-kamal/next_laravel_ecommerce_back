<?php

namespace App\Interfaces\Admins;

use App\Http\Requests\{ItemRequest};
use App\Models\Item;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

interface ItemRepositoryInterface
{
    public function index(Request $request): Paginator;

    public function store(ItemRequest $request, FileRepositoryInterface $fileRepository): void;

    public function show(Item $item): mixed;

    public function update(ItemRequest $request, FileRepositoryInterface $fileRepository, Item $item): void;

    public function delete(Item $item): void;
}
