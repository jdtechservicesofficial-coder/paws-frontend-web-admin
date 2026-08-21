<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'slug'        => $this->type,
            'name'        => $this->name,
            'description' => $this->description,
            'url'         => route('pages', ['slug' =>  $this->type])
        ];
    }
}
