<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
