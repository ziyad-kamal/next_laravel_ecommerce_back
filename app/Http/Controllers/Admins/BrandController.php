<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\{BrandRequest};
use App\Http\Resources\BrandResource;
use App\Interfaces\Admins\BrandRepositoryInterface;
use App\Models\Brand;
use App\Traits\{GetDataByLang, Response};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandController extends Controller
{
    use GetDataByLang,Response;

    public function __construct(protected BrandRepositoryInterface $brandRepository) {}

    // MARK: index
    public function index(Request $request): AnonymousResourceCollection
    {
        $brands = $this->brandRepository->index($request);

        return BrandResource::collection($brands);
    }

    // MARK: store
    public function store(BrandRequest $request): JsonResponse
    {
        $this->brandRepository->store($request);

        return $this->returnSuccess('you successfully created brand');
    }

    // MARK: show
    public function show(Brand $brand): AnonymousResourceCollection
    {
        $allBrands = $this->brandRepository->show($brand);

        return BrandResource::collection($allBrands);
    }

    // MARK: update
    public function update(BrandRequest $request): JsonResponse
    {
        $this->brandRepository->update($request);

        return $this->returnSuccess('you successfully update brand');
    }

    // MARK: destroy
    public function destroy(Brand $brand): JsonResponse
    {
        $this->brandRepository->delete($brand);

        return $this->returnSuccess('you successfully deleted brand');
    }
}
