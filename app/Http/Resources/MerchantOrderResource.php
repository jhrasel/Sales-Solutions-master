<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\OrderNote;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @property Order $resource
 */

class MerchantOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $note = OrderNote::query()->where('type', $this->order_status)->first();
        return [
            'id' => $this->resource->id,
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
            'note' => $note->note,
            'courier_entry' => $this->config->courier_entry === true,
            'order_details' => OrderDetailsResource::collection($this->order_details)
        ];
    }
}
