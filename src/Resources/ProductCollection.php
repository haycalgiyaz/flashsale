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
            'text' => '<span class="badge badge-'.($this->is_publish ? 'success' : 'secondary').' badge-pill" style="width:10px; height:10px; line-height:2px">&nbsp;</span>&nbsp;'.$this->name,
            'text_sort' => '<span class="badge badge-'.($this->is_publish ? 'success' : 'secondary').' badge-pill" style=" line-height:2px">&nbsp;</span>&nbsp;'.substr($this->name, 0, 30),
            'state' => ['opened' => true, 'selected' => (bool) $this->flashsale_count]

        ];
    }
}