<?php

namespace Dhcd\Api\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
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
            'list_forums' => $this->collection,
            'id' => $this->topic_id,
            'title' => $this->name,
            'photo' => $this->image,
            'date_created' => date_format($this->created_at, 'Y-m-d'),
            'date_modified' => date_format($this->updated_at, 'Y-m-d'),
            'isEnable' => ($this->joined == 1) ? true : false
        ];
//        return parent::toArray($request);
    }
}
