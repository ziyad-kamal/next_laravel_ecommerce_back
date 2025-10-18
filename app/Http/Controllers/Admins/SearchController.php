<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Resources\{BrandResource, CategoryResource};
use App\Models\{Brand, Category};
use App\Traits\{CanAccessAdminPanel, GetDataByLang, Response};
use Illuminate\Http\{Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchController extends Controller
{
    use CanAccessAdminPanel,GetDataByLang,Response;

    public function __construct()
    {
        $this->canAccessAdminPanel();
    }

    // MARK: index
    public function categories(Request $request): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->where('name', 'like', "{$request->search}%")
            ->limit(5)
            ->get();

        return CategoryResource::collection($categories);
    }

    // MARK: store
    public function brands(Request $request): AnonymousResourceCollection
    {
        $brands = Brand::query()
            ->where('name', 'like', "{$request->search}%")
            ->limit(5)
            ->get();

        return BrandResource::collection($brands);
    }
}
