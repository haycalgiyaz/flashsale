<?php

namespace Haycalgiyaz\Flashsale\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent' => (!$this->parent_id ? '#' : $this->parent_id),
            'is_publish' => $this->is_publish,
            'name' => $this->name,
            // 'state' => ['opened' => true, 'selected' => (bool) $this->flashsale_count]
            'selected' => $this->flashsale_count

        ];
    }
}