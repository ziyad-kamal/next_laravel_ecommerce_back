<?php

namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait GetDataByLang
{
    public function getDataByDefaultLang(array $data, FormRequest $request): array
    {
        $authId         = $request->user()->id;
        $defaultLang    = Cache::get("defaultLang{$authId}");
        $collected_data = collect($data);

        $filter         = $collected_data->filter(function ($val) use ($defaultLang) {
            return $val['trans_lang'] == $defaultLang;
        });

        return array_values($filter->all())[0];
    }

    public function getDataByOtherLangs(array $data, FormRequest $request): Collection
    {
        $authId         = $request->user()->id;
        $defaultLang    = Cache::get("defaultLang{$authId}");
        $collected_data = collect($data);

        return $collected_data->filter(function ($val) use ($defaultLang) {
            return $val['trans_lang'] != $defaultLang;
        });
    }
}
