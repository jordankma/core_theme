<?php

namespace Dhcd\Api\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'event_id' => $this->event_id,
            'name' => $this->name,
            'date' => $this->date,
            'content' => $this->content,
            'event_detail' => json_decode($this->event_detail)
        ];
//        return parent::toArray($request);
    }
}
