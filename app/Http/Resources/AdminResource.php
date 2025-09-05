<?php

namespace App\Http\Resources;

use App\Traits\{ResponseMessage};
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    // use ResponseMessage;

    public static $wrap = 'admin';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $req_method = $request->method();

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        $req_method = $request->method();

        $data = [];

        if ($req_method !== 'GET') {
            $data['message'] = $req_method === 'POST' ? 'you successfully created '.self::$wrap : 'you successfully updated the '.self::$wrap;
        }

        return $data;
    }
}
