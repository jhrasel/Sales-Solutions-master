<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use JsonSerializable;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_no' => (int)$this->order_no,
            'shop_id' => $this->shop_id,
            'customer_name' => $this->customer_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'order_status' => $this->order_status,
            'cod' => $this->cod === 1,
            'grand_total' => $this->pricing->grand_total,
            'advanced' => $this->pricing->advanced,
            'due' => $this->pricing->due,
            'shipping_cost' => $this->pricing->shipping_cost,
            'delivery_location' => Str::ucfirst(Str::replace('_', ' ', $this->delivery_location)),
            'order_details' => OrderDetailsResource::collection($this->order_details)
        ];
    }
}
