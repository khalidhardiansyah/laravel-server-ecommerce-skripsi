<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user_id' =>$this->user_id,
            'jumlah_item' =>$this->jumlah_item,
            'stock' => new StockResource($this->whenLoaded('stock')),
            'product' => new ProductResource($this->whenLoaded('product'), $this->product->thumb),
            // 'products' => ProductResource::collection($this->whenLoaded('product')),
            // 'stock'=> StockResource::collection($this->whenLoaded('stock')),
        ];
    }
}
