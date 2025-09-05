<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LangRequest};
use App\Traits\Response;
use Illuminate\Http\{JsonResponse};
use Illuminate\Support\Facades\Cache;

class LangController extends Controller
{
    use Response;

    /**
     * Store a newly created resource in storage.
     */
    public function store(LangRequest $request): JsonResponse
    {
        $authId = $request->user()->id;
        Cache::put("defaultLang{$authId}", $request->defaultLang);

        return $this->returnSuccess('you successfully store default Language');
    }
}
