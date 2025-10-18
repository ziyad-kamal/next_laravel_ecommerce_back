<?php

namespace App\Repositories\Admins;

use App\Http\Requests\{OrderRequest};
use App\Interfaces\Admins\{OrderRepositoryInterface};
use App\Models\{Order};
use App\Traits\{CreateSlug, GetDataByLang, UploadImage};
use Illuminate\Contracts\Pagination\Paginator;

class OrderRepository implements OrderRepositoryInterface
{
    use CreateSlug,GetDataByLang,UploadImage;

    // MARK: index
    public function index(): Paginator
    {
        $keyToSort   = $request->keyToSort   ?? 'created_at';
        $direction   = $request->direction   ?? 'desc';

        return Order::query()
            ->with(['items', 'user'])
            ->orderBy($keyToSort, $direction)
            ->paginate(10);
    }

    // MARK: store
    public function store(OrderRequest $request): void
    {
        $items        = $request->items;
        $defaultOrder = $this->getDataByDefaultLang($items, $request);
        $adminId      = $request->user()->id;
        $slug         = $this->createSlug('items', 'name', $defaultOrder['name']);

        $defaultOrderId = Order::insertGetId([
            'trans_lang'            => $defaultOrder['trans_lang'],
            'name'                  => $defaultOrder['name'],
            'slug'                  => $slug,
            'approval'              => 1,
            'admin_id'              => $adminId,
            'category_id'           => $defaultOrder['category_id'],
            'brand_id'              => $defaultOrder['brand_id'],
            'created_at'            => now(),
        ]);

        Order::where('id', $defaultOrderId)->update(['trans_of' => $defaultOrderId]);

        $otherOrders = $this->getDataByOtherLangs($items, $request);

        if ($otherOrders !== []) {

            foreach ($otherOrders as $otherOrder) {
                $slug = $this->createSlug('items', 'name', $otherOrder['name']);

                $itemId = Order::insertGetId([
                    'trans_lang'            => $otherOrder['trans_lang'],
                    'trans_of'              => $defaultOrderId,
                    'name'                  => $otherOrder['name'],
                    'slug'                  => $slug,
                    'approval'              => 1,
                    'admin_id'              => $adminId,
                    'category_id'           => $otherOrder['category_id'],
                    'brand_id'              => $otherOrder['brand_id'],
                    'created_at'            => now(),
                ]);

            }

        }
    }

    // MARK: show
    public function show(Order $item): mixed
    {
        return Order::query()
            ->with(['admin', 'category', 'brand', 'item_info', 'item_files'])
            ->where('trans_of', $item->id)
            ->get();

    }

    // MARK: update
    public function update(OrderRequest $request, Order $defaultOrder): void
    {
        $items       = $request->items;
        $adminId     = $request->user()->id;

        foreach ($items as $item) {
            if ($item['id'] != 0) {
                Order::query()
                    ->where('id', $item['id'])
                    ->update([
                        'name'                       => $item['name'],
                        'category_id'                => $item['category_id'],
                        'brand_id'                   => $item['brand_id'],
                    ]);

            } else {
                $slug  = $this->createSlug('items', 'name', $item['name']);

                Order::create([
                    'trans_lang'           => $item['trans_lang'],
                    'trans_of'             => $defaultOrder->id,
                    'name'                 => $item['name'],
                    'slug'                 => $slug,
                    'approve'              => 'approved',
                    'admin_id'             => $adminId,
                    'category_id'          => $item['category_id'],
                    'brand_id'             => $item['brand_id'],
                ]);

            }
        }
    }

    // MARK: delete
    public function delete(Order $item): void
    {

        Order::where('trans_of', $item->trans_of)->delete();
    }
}
