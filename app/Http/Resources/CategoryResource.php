<?php

namespace App\Http\Resources;
use Illuminate\Support\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "id" => $this->id,
            "nama_category"=>$this->nama_category,
            "created"=>Carbon::parse($this->crated_at)->format('d-m-y'),
            "products" => ProductResource::collection($this->whenLoaded("product"))
        ];
    }
}
