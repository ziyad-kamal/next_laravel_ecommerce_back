<?php

namespace App\Interfaces\Admins;

use App\Http\Requests\{BrandRequest};
use App\Models\Brand;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

interface BrandRepositoryInterface
{
    public function index(Request $request): Paginator;

    public function store(BrandRequest $request): void;

    public function show(Brand $brand): mixed;

    public function update(BrandRequest $request): void;

    public function delete(Brand $brand): void;
}
