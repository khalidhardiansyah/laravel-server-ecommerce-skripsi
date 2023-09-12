<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'size'=>$this->size,
            'stock'=> $this->stock,

        ];
    }
    // public function with($request)
    // {
    //     return [
    //             'product'=> ProductResource::collection($this->whenLoaded('product')),
    //         ];
    // }
}
