<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThumbResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'path_thumb' => $this->path_thumb,
            'products_id' => $this->products_id
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'product'=>  ProductResource::collection($this->whenLoaded('product')),
    //         ];
    // }
}
