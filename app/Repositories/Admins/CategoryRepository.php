<?php

namespace App\Repositories\Admins;

use App\Http\Requests\{CategoryRequest};
use App\Interfaces\Admins\{CategoryRepositoryInterface};
use App\Models\{Category};
use App\Traits\{GetDataByLang, UploadImage};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache};

class CategoryRepository implements CategoryRepositoryInterface
{
    use GetDataByLang,UploadImage;

    // MARK: index
    public function index(Request $request): Paginator
    {
        $userId      = $request->user()->id;
        $defaultLang = Cache::get("defaultLang{$userId}", 'en');
        $keyToSort   = $request->keyToSort   ?? 'created_at';
        $direction   = $request->direction   ?? 'desc';

        return Category::query()
            ->selection()
            ->with('admin')
            ->where('trans_lang', $defaultLang)
            ->orderBy($keyToSort, $direction)
            ->paginate(5);
    }

    // MARK: store
    public function store(CategoryRequest $request): void
    {
        $categories           = $request->categories;
        $defaultCategory      = $this->getDataByDefaultLang($categories, $request);
        $adminId              = $request->user()->id;

        $image = $this->uploadImage($request, 'category', 300);

        $defaultCategoryId = Category::insertGetId([
            'trans_lang'        => $defaultCategory['trans_lang'],
            'name'              => $defaultCategory['name'],
            'image'             => $image,
            'admin_id'          => $adminId,
            'created_at'        => now(),
        ]);

        Category::where('id', $defaultCategoryId)->update(['trans_of' => $defaultCategoryId]);

        $otherCategories = $this->getDataByOtherLangs($categories, $request);

        if ($otherCategories !== []) {
            $otherCategoriesArr = [];
            foreach ($otherCategories as $otherCategory) {
                $otherCategoriesArr[] = [
                    'trans_lang'        => $otherCategory['trans_lang'],
                    'trans_of'          => $defaultCategoryId,
                    'name'              => $otherCategory['name'],
                    'image'             => $image,
                    'admin_id'          => $adminId,
                    'created_at'        => now(),
                ];
            }

            Category::insert($otherCategoriesArr);
        }
    }

    // MARK: show
    public function show(Category $category): mixed
    {
        $otherLangCategories = Category::where('trans_of', $category->id)->get();
        $category            = collect([$category]);

        return $otherLangCategories->merge($category);
    }

    // MARK: update
    public function update(CategoryRequest $request): void
    {
        $categories  = $request->categories;

        foreach ($categories as $category) {
            Category::where('id', $category['id'])->update(['name' => $category['name']]);
        }
    }

    // MARK: delete
    public function delete(Category $category): void
    {
        Category::where('trans_of', $category->trans_of)->delete();
    }
}
