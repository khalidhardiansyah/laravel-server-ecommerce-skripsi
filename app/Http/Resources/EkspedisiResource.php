<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EkspedisiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'nama_ekspedisi' => $this->nama_ekspedisi,
            'biaya' => $this->biaya
        ];
    }
}
