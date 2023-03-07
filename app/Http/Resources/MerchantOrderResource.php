<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\OrderNote;
use App\Services\Courier;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use JsonSerializable;

/**
 * @property Order $resource
 */

class MerchantOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array
    {
        $status = $this->order_status ?? Order::PENDING;
        $note = OrderNote::query()->where('order_id', $this->resource->id)->where('type', $status)->first();
        return [
            'id' => $this->resource->id,
            'order_no' => (int)$this->resource->order_no,
            'shop_id' => $this->resource->shop_id,
            'customer_name' => $this->resource->customer_name,
            'phone' => $this->resource->phone,
            'address' => $this->resource->address,
            'order_status' => $this->resource->order_status,
            'cod' => $this->resource->cod === 1,
            'grand_total' => $this->resource->pricing->grand_total,
            'advanced' => $this->resource->pricing->advanced,
            'due' => (int)$this->resource->pricing->due,
            'shipping_cost' => $this->resource->pricing->shipping_cost,
            'delivery_location' => Str::ucfirst(Str::replace('_', ' ', $this->resource->delivery_location)),
            'note' => $note ? $note->note : null,
            'courier_entry' => $this->resource->config->courier_entry == true,
            'tracking_code' => $this->resource->courier->tracking_code,
            'courier_status' => Courier::status($this->resource->courier->status),
            'order_details' => OrderDetailsResource::collection($this->resource->order_details)
        ];
    }
}
