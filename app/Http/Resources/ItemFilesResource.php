<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemFilesResource extends JsonResource
{
    public static $wrap = 'files';

    public function toArray(Request $request): array
    {
        return [
            'path'                 => $this->path,
            'created_at'           => $this->created_at,
        ];
    }

    public function with(Request $request): array
    {
        $req_method = $request->method();

        $data = [];

        if ($req_method !== 'GET') {
            $data['message'] = $req_method === 'POST' ? 'you successfully created '.self::$wrap : 'you successfully updated the '.self::$wrap;
        }

        return $data;
    }
}
