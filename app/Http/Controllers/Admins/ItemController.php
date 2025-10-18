<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\{ItemRequest};
use App\Http\Resources\ItemResource;
use App\Interfaces\Admins\{FileRepositoryInterface, ItemRepositoryInterface};
use App\Models\Item;
use App\Traits\{CanAccessAdminPanel, GetDataByLang, Response};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    use CanAccessAdminPanel,GetDataByLang,Response;

    public function __construct(protected ItemRepositoryInterface $itemRepository)
    {
        $this->canAccessAdminPanel();
    }

    // MARK: index
    public function index(Request $request): AnonymousResourceCollection
    {
        $items = $this->itemRepository->index($request);

        return ItemResource::collection($items);
    }

    // MARK: store
    public function store(ItemRequest $request, FileRepositoryInterface $fileRepository): JsonResponse
    {
        $this->itemRepository->store($request, $fileRepository);

        return $this->returnSuccess('you successfully created item');
    }

    // MARK: show
    public function show(Item $item): AnonymousResourceCollection
    {
        $allItems = $this->itemRepository->show($item);

        return ItemResource::collection($allItems);
    }

    // MARK: update
    public function update(ItemRequest $request, FileRepositoryInterface $fileRepository, Item $item): JsonResponse
    {
        $this->itemRepository->update($request, $fileRepository, $item);

        return $this->returnSuccess('you successfully updated item');
    }

    // MARK: destroy
    public function destroy(Item $item): JsonResponse
    {
        $this->itemRepository->delete($item);

        return $this->returnSuccess('you successfully deleted item');
    }
}
