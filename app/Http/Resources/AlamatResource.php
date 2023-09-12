<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlamatResource extends JsonResource
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
            "alamat_detail" => $this->alamat_detail,
            "kode_pos"=> $this->kode_pos,
            "kelurahan" => [ "id" => $this->kelurahan->id,
             "code" => $this->kelurahan->code,
             "district_code" => $this->kelurahan->district_code,
             "name" => $this->kelurahan->name,],
            "kecamatan"=> [ "id" => $this->kecamatan->id,
             "code" => $this->kecamatan->code,
             "city_code" => $this->kecamatan->city_code,
             "name" => $this->kecamatan->name,],
            "kabupaten"=> [ "id" => $this->kabupaten->id,
             "code" => $this->kabupaten->code,
             "province_code" => $this->kabupaten->province_code,
             "name" => $this->kabupaten->name,
            ],
             
            "provinsi" => [ "id" => $this->provinsi->id,
             "code" => $this->provinsi->code,
             "name" => $this->provinsi->name,
            ]
        ];
    }
}
