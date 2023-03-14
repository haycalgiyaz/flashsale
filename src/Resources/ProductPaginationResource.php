<?php

namespace Haycalgiyaz\Flashsale\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Haycalgiyaz\Flashsale\Resources\ProductCollection;

class ProductPaginationResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'items' => ProductCollection::collection($this),
            'lastPage' => $this->lastPage(),
            'total' => $this->count(),
            'currentPage' => $this->currentPage(),
            'nextPageUrl' => $this->nextPageUrl(),
            'prevPageUrl' => $this->previousPageUrl(),
        ];
    }
}