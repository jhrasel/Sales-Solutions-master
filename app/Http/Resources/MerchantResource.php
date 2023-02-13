<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' =>  $this->name,
            'domain' =>  $this->shop->domain,
            'email' =>  $this->email,
            'phone' =>  $this->phone,
            'role' =>  $this->role,
            'shop_id' =>  $this->shop->shop_id,
            'avatar' =>  $this->avatar,
        ];
    }
}
