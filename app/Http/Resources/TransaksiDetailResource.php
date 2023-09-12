<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiDetailResource extends JsonResource
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
            'jumlah' =>$this->jumlah,
            'total_harga' =>$this->total_harga,
            'list_produk' => new ProductResource($this->whenLoaded("product"),$this->product->thumb),
            'stock'=> new StockResource($this->whenLoaded("stock"))
        ];
    }
}
