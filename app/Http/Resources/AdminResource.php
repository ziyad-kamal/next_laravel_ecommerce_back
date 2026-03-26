<?php

namespace App\Http\Resources;

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
        return [
            'name'                => $this->name,
            'email'               => $this->email,
            'bio'                 => $this->bio,
            'phone'               => $this->phone,
            'address'             => $this->address,
            'role'                => $this->role->label(),
            'permissions'         => $this->permissions,
            'email'               => $this->email,
            'created_at'          => $this->created_at,
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
