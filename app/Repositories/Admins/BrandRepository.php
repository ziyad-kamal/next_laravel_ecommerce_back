<?php

namespace App\Repositories\Admins;

use App\Http\Requests\{BrandRequest};
use App\Interfaces\Admins\{BrandRepositoryInterface};
use App\Models\{Brand};
use App\Traits\{GetDataByLang};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache};

class BrandRepository implements BrandRepositoryInterface
{
    use GetDataByLang;

    // MARK: index
    public function index(Request $request): Paginator
    {
        $userId      = $request->user()->id;
        $defaultLang = Cache::get("defaultLang{$userId}", 'en');
        $keyToSort   = $request->keyToSort   ?? 'created_at';
        $direction   = $request->direction   ?? 'desc';

        return Brand::query()
            ->selection()
            ->with('admin')
            ->where('trans_lang', $defaultLang)
            ->orderBy($keyToSort, $direction)
            ->paginate(10);
    }

    // MARK: store
    public function store(BrandRequest $request): void
    {
        $brands        = $request->brands;
        $defaultBrand  = $this->getDataByDefaultLang($brands, $request);
        $adminId       = $request->user()->id;

        $defaultBrandId = Brand::insertGetId([
            'trans_lang'       => $defaultBrand['trans_lang'],
            'name'             => $defaultBrand['name'],
            'admin_id'         => $adminId,
            'created_at'       => now(),
        ]);

        Brand::where('id', $defaultBrandId)->update(['trans_of' => $defaultBrandId]);

        $otherBrands = $this->getDataByOtherLangs($brands, $request);

        if ($otherBrands !== []) {
            $otherBrandsArr = [];
            foreach ($otherBrands as $otherBrand) {
                $otherBrandsArr[] = [
                    'trans_lang'       => $otherBrand['trans_lang'],
                    'trans_of'         => $defaultBrandId,
                    'name'             => $otherBrand['name'],
                    'admin_id'         => $adminId,
                    'created_at'       => now(),
                ];
            }

            Brand::insert($otherBrandsArr);
        }
    }

    // MARK: show
    public function show(Brand $brand): mixed
    {
        $otherLangBrands  = Brand::where('trans_of', $brand->id)->get();
        $brand            = collect([$brand]);

        return $otherLangBrands->merge($brand);
    }

    // MARK: update
    public function update(BrandRequest $request): void
    {
        $brands  = $request->brands;

        foreach ($brands as $brand) {
            Brand::where('id', $brand['id'])->update(['name' => $brand['name']]);
        }
    }

    // MARK: delete
    public function delete(Brand $brand): void
    {
        Brand::where('trans_of', $brand->trans_of)->delete();
    }
}
