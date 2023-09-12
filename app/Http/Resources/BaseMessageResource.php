<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $message;

    public function __construct($message)
    {
       $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            "message"=>$this->message
        ];
    }
}
