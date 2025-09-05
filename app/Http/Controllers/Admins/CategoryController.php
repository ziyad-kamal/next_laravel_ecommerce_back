<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\{CategoryRequest};
use App\Http\Resources\CategoryResource;
use App\Interfaces\Admins\CategoryRepositoryInterface;
use App\Models\Category;
use App\Traits\{GetDataByLang, Response};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    use GetDataByLang,Response;

    public function __construct(protected CategoryRepositoryInterface $categoryRepository) {}

    // MARK: index
    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = $this->categoryRepository->index($request);

        return CategoryResource::collection($categories);
    }

    // MARK: store
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->categoryRepository->store($request);

        return $this->returnSuccess('you successfully created category');
    }

    // MARK: show
    public function show(Category $category): AnonymousResourceCollection
    {
        $allCategories = $this->categoryRepository->show($category);

        return CategoryResource::collection($allCategories);
    }

    // MARK: update
    public function update(CategoryRequest $request): JsonResponse
    {
        $this->categoryRepository->update($request);

        return $this->returnSuccess('you successfully update category');
    }

    // MARK: destroy
    public function destroy(Category $category): JsonResponse
    {
        $this->categoryRepository->delete($category);

        return $this->returnSuccess('you successfully deleted category');
    }
}
