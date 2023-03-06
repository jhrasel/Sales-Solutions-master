<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function store(OrderRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {

            $order = Order::query()->create([
                'order_no' => rand(100, 9999),
                'shop_id' => $request->header('shop-id'),
                'address' => $request->input('customer_address'),
                'phone' => $request->input('customer_phone'),
                'customer_name' => $request->input('customer_name'),
                'delivery_location' => $request->input('delivery_location'),
            ]);


            $grand_total = 0;
            $shipping_cost = 0;

            //store order details
            foreach ($request->input('product_id') as $key => $item) {

                $product = Product::query()->find($item);

                $order->order_details()->create([
                    'product_id' => $item,
                    'product_qty' => $request->input('product_qty')[$key],
                    'unit_price' => $product->price,
                ]);

                $grand_total += $product->price * $request->input('product_qty')[$key];
                if ($product->delivery_charge === Product::PAID) {
                    $shipping_cost += $product[$request->input('delivery_location')];
                }

            }
            $order->pricing()->create([
                'shipping_cost' => $shipping_cost,
                'grand_total' => $grand_total
            ]);

            if ($request->filled('note')) {

                $note = OrderNote::query()->create([
                    'order_id' => $order->id,
                    'type' => Order::PENDING,
                    'note' => $request->input('note')
                ]);
            }

            $order->config()->create();
            $order->courier()->create();

            $order->load('order_details', 'pricing');
            foreach ($order->order_details as $details) {
                $details->product->update([
                    'product_qty' => $details->product->product_qty - $details->product_qty
                ]);
            }

            return $this->sendApiResponse(new OrderResource($order), 'Order Created Successfully');
        });

    }

    public function show($id): JsonResponse
    {
        $order = Order::query()->with('order_details', 'pricing')->find($id);

        return $this->sendApiResponse(new OrderResource($order));
    }
}
