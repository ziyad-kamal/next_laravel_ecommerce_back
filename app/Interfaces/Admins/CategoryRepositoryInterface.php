<?php

namespace App\Interfaces\Admins;

use App\Http\Requests\{CategoryRequest};
use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function index(Request $request): Paginator;

    public function store(CategoryRequest $request): void;

    public function show(Category $brand): mixed;

    public function update(CategoryRequest $request, Category $category): void;

    public function delete(Category $brand): void;
}
