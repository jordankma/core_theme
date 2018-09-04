<?php

namespace Dhcd\Api\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'id' => $this->menu_id,
            'title' => $this->name,
            'icon' => $this->icon
        ];
//        return parent::toArray($request);
    }
}
