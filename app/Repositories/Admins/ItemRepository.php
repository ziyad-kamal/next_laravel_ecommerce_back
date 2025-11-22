<?php

namespace App\Repositories\Admins;

use App\Http\Requests\{ItemRequest};
use App\Interfaces\Admins\{FileRepositoryInterface, ItemRepositoryInterface};
use App\Models\{Item, Item_files, Item_info};
use App\Traits\{CreateSlug, GetDataByLang, UploadImage};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Storage};

class ItemRepository implements ItemRepositoryInterface
{
    use CreateSlug,GetDataByLang,UploadImage;

    // MARK: index
    public function index(Request $request): Paginator
    {
        $userId      = $request->user()->id;
        $defaultLang = Cache::get("defaultLang{$userId}", 'en');
        $keyToSort   = $request->keyToSort   ?? 'created_at';
        $direction   = $request->direction   ?? 'desc';

        return Item::query()
            ->selection()
            ->with(['admin', 'category', 'brand', 'item_info'])
            ->where('trans_lang', $defaultLang)
            ->orderBy($keyToSort, $direction)
            ->paginate(10);
    }

    // MARK: store
    public function store(ItemRequest $request, FileRepositoryInterface $fileRepository): void
    {
        $items       = $request->items;
        $defaultItem = $this->getDataByDefaultLang($items, $request);
        $adminId     = $request->user()->id;
        $slug        = $this->createSlug('items', 'name', $defaultItem['name']);

        $defaultItemId = Item::insertGetId([
            'trans_lang'            => $defaultItem['trans_lang'],
            'name'                  => $defaultItem['name'],
            'slug'                  => $slug,
            'approval'              => 1,
            'admin_id'              => $adminId,
            'category_id'           => $defaultItem['category_id'],
            'brand_id'              => $defaultItem['brand_id'],
            'created_at'            => now(),
        ]);

        Item_info::create([
            'description'            => $defaultItem['description'],
            'price'                  => $defaultItem['price'],
            'condition'              => $defaultItem['condition'],
            'item_id'                => $defaultItemId,
            'trans_lang'             => $defaultItem['trans_lang'],
            'trans_of'               => $defaultItemId,
        ]);

        $fileRepository->insert_files($request, 'items_files', 'item_id', $defaultItemId);

        Item::where('id', $defaultItemId)->update(['trans_of' => $defaultItemId]);

        $otherItems = $this->getDataByOtherLangs($items, $request);

        if ($otherItems !== []) {

            foreach ($otherItems as $otherItem) {
                $slug = $this->createSlug('items', 'name', $otherItem['name']);

                $itemId = Item::insertGetId([
                    'trans_lang'            => $otherItem['trans_lang'],
                    'trans_of'              => $defaultItemId,
                    'name'                  => $otherItem['name'],
                    'slug'                  => $slug,
                    'approval'              => 1,
                    'admin_id'              => $adminId,
                    'category_id'           => $otherItem['category_id'],
                    'brand_id'              => $otherItem['brand_id'],
                    'created_at'            => now(),
                ]);

                Item_info::insert([
                    'trans_lang'             => $otherItem['trans_lang'],
                    'trans_of'               => $defaultItemId,
                    'description'            => $otherItem['description'],
                    'price'                  => $otherItem['price'],
                    'condition'              => $otherItem['condition'],
                    'item_id'                => $itemId,
                ]);
            }

        }
    }

    // MARK: show
    public function show(Item $item): mixed
    {
        return Item::query()
            ->with(['admin', 'category', 'brand', 'item_info', 'item_files'])
            ->where('trans_of', $item->id)
            ->get();

    }

    // MARK: update
    public function update(ItemRequest $request, FileRepositoryInterface $fileRepository, Item $defaultItem): void
    {
        $items       = $request->items;
        $adminId     = $request->user()->id;

        $fileRepository->insert_files($request, 'items_files', 'item_id', $defaultItem->id);

        foreach ($items as $item) {
            if ($item['id'] != 0) {
                Item::query()
                    ->where('id', $item['id'])
                    ->update([
                        'name'                       => $item['name'],
                        'category_id'                => $item['category_id'],
                        'brand_id'                   => $item['brand_id'],
                    ]);

                Item_info::query()
                    ->where(['id' => $item['id'], 'trans_lang' => $item['trans_lang']])
                    ->update([
                        'description'            => $item['description'],
                        'price'                  => $item['price'],
                        'condition'              => $item['condition'],
                    ]);
            } else {
                $slug  = $this->createSlug('items', 'name', $item['name']);

                Item::create([
                    'trans_lang'           => $item['trans_lang'],
                    'trans_of'             => $defaultItem->id,
                    'name'                 => $item['name'],
                    'slug'                 => $slug,
                    'approve'              => 'approved',
                    'admin_id'             => $adminId,
                    'category_id'          => $item['category_id'],
                    'brand_id'             => $item['brand_id'],
                ]);

                Item_info::create([
                    'trans_lang'             => $item['trans_lang'],
                    'trans_of'               => $defaultItem->id,
                    'description'            => $item['description'],
                    'price'                  => $item['price'],
                    'condition'              => $item['condition'],
                    'item_id'                => $defaultItem->id,
                ]);
            }
        }
    }

    // MARK: delete
    public function delete(Item $item): void
    {
        $images      = Item_files::where('item_id', $item->id)->pluck('path')->toArray();

        if ($images != []) {
            $locationArr = [];
            foreach ($images as $image) {
                $location      = str_replace(url('storage'), '', $image);
                $locationArr[] = $location;
            }

            Storage::disk('public')->delete($locationArr);
        }

        Item::where('trans_of', $item->trans_of)->delete();
    }
}
