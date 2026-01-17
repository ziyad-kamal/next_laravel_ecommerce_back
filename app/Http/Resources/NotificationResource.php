<?php

namespace App\Http\Resources;

use App\Traits\{ResponseMessage};
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    // use ResponseMessage;

    public static $wrap = 'notification';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'admin_id'             => $this->data['admin_id'],
            'notification_id'      => $this->id,
            'admin_name'           => $this->data['admin_name'],
            'title'                => $this->data['title'],
            'message'              => $this->data['message'],
            'created_at'           => Carbon::parse($this->created_at)->diffForHumans(),
            'is_read'              => $this->read_at ? true : false,
        ];
    }
}
