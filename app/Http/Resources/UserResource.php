<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' =>$this->name,
            'email' =>$this->email,
            'no_hp' =>$this->no_hp,
            'role_id' =>$this->role->nama_role,
            'alamat'=> AlamatResource::collection($this->alamat)
        ];
    }
}
