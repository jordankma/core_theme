<?php

namespace Dhcd\Api\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsHomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sub_title = $this->getCats[0]->name . ' ' . date_format($this->getCats[0]->created_at, 'd-m-Y');
        return [
            'id' => $this->news_id,
            'title' => base64_encode($this->title),
            'sub_title' => base64_encode($sub_title),
            'describe' => base64_encode($this->desc),
            'photo' => $this->image,
            'content' => base64_encode($this->content),
            'date_created' => date_format($this->created_at, 'Y-m-d'),
            'date_modified' => date_format($this->updated_at, 'Y-m-d'),
            'is_top_new' => ($this->is_hot == 1) ? true : false
        ];
//        return parent::toArray($request);
    }
}
