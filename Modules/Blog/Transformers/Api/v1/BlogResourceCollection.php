<?php

namespace Modules\Blog\Transformers\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\FileLibrary\Entities\FileLibrary;

class BlogResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item){
                return [
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'thumbnail' => 'storage/' . FileLibrary::find($item->thumbnail)->path .'full/'. FileLibrary::find($item->thumbnail)->file_name,
                    'desc' => \App\Http\Controllers\HomeController::TruncateString($item->desc, 275, 1),
                ];
            })
        ];
    }
}
