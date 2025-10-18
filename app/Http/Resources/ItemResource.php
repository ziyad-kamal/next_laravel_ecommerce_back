<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public static $wrap = 'item';

    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'admin_name'           => $this->admin?->name,
            'category_name'        => $this->category?->name,
            'category_id'        => $this->category?->id,
            'brand_name'           => $this->brand?->name,
            'brand_id'           => $this->brand?->id,
            'description'          => $this->item_info?->description,
            'price'                => $this->item_info?->price,
            'condition'            => $this->item_info?->condition->label(),
            'approval'             => $this->approval->label(),
            'images'               => ItemFilesResource::collection($this->whenLoaded('item_files')),
            'trans_lang'           => $this->trans_lang,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
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
