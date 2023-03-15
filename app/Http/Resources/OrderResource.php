<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\OrderDate;
use App\Models\OrderNote;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use JsonSerializable;

/**
 * @property Order $resource
 */

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $status = $this->order_status ?? Order::PENDING;
        $note = OrderNote::query()->where('order_id', $this->resource->id)->where('type', $status)->first();
        $date = OrderDate::query()->where('order_id', $this->resource->id)->where('type', $status)->first();

        return [
            'id' => $this->resource->id,
            'order_no' => (int)$this->resource->order_no,
            'shop_id' => $this->resource->shop_id,
            'customer_name' => $this->resource->customer_name,
            'phone' => $this->resource->phone,
            'address' => $this->resource->address,
            'order_status' => $this->resource->order_status,
            'cod' => $this->resource->cod == 1,
            'grand_total' => $this->resource->pricing->grand_total,
            'advanced' => $this->resource->pricing->advanced,
            'due' => $this->resource->pricing->due,
            'shipping_cost' => $this->resource->pricing->shipping_cost,
            'delivery_location' => Str::ucfirst(Str::replace('_', ' ', $this->resource->delivery_location)),
            'note' => $note->note ?? null,
            'order_details' => OrderDetailsResource::collection($this->resource->order_details),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            $this->resource->order_status.'_date' => $date->date ?? null,
        ];
    }
}
