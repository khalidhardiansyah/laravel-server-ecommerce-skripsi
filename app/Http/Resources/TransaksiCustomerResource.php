<?php

namespace App\Http\Resources;

use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiCustomerResource extends JsonResource
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
            "order_number" =>$this->order_number,
            "kurir" => $this->kurir,
            "biaya_pengiriman" => $this->biaya_pengiriman,
            "tgl_pemesanan" => Carbon::parse($this->created_at)->format('F d, Y'),
            "status_transaksi"=>$this->status,
            'transaksi_detail'=> TransaksiDetailResource::collection($this->whenLoaded('transaksiDetail')),
            'payment'=> new PaymentResource($this->whenLoaded('payment'))
        ];
    }
}
