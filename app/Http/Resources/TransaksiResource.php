<?php

namespace App\Http\Resources;
use Illuminate\Support\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
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
            "id"=>$this->id,
            "order_number"=>$this->order_number,
            "user"=> new UserResource($this->whenLoaded('user')),
            "kurir"=> $this->kurir,
            "service"=>$this->service,
            "status_transaksi"=>$this->status,
            "biaya_pengiriman" => $this->biaya_pengiriman,
            "tanggal_transaksi"=> Carbon::parse($this->created_at)->format('d-m-Y'),
            'transaksi_detail'=> TransaksiDetailResource::collection($this->whenLoaded('transaksiDetail')),
            'payment'=> new PaymentResource($this->whenLoaded('payment'))
        ];
    }
}
