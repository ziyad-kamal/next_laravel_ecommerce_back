<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = 'order';

    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'total_amount'          => $this->total_amount,
            'user_name'             => $this->user?->name,
            'items'                 => ItemResource::collection($this->whenLoaded('items')),
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
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
