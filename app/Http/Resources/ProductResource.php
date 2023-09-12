<?php

namespace App\Http\Resources;

use App\Models\Stock;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StockResource;
use App\Http\Resources\ThumbResource;
class ProductResource extends JsonResource
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
            'id' =>$this->id,
            'nama_barang' => $this->nama_barang,
            'deskripsi' => $this->deskripsi,
            'harga_modal'=>$this->harga_modal,
            'harga_jual' => $this->harga_jual,
            'category'=>$this->category,
            'stock'=> StockResource::collection($this->whenLoaded('stocks')),
            'thumb'=> ThumbResource::collection($this->whenLoaded('thumb'))
        ];
    }

    public function with($request)
    {
        return [
                // 'stock'=> StockResource::collection($this->whenLoaded('stocks')),
                // 'thumb'=> ThumbResource::collection($this->whenLoaded('thumb'))
            ];
    }
 }
