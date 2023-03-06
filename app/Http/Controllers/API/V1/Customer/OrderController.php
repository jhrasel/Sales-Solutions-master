<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function store(OrderRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $order = Order::query()->create([
                'order_no' => rand(100, 9999),
                'shop_id' => $request->header('shop-id'),
                'customer_name' => $request->input('customer_name'),
                'phone' => $request->input('customer_phone'),
                'address' => $request->input('customer_address')
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
            $order->shipping_cost = $shipping_cost;
            $order->grand_total = $grand_total;
            $order->save();

            $order->load('customer', 'order_details');
            foreach ($order->order_details as $details) {
                $details->product->update([
                    'product_qty' => $details->product->product_qty - $details->product_qty
                ]);
            }

            return $this->sendApiResponse($order, 'Order Created Successfully');
        });

    }

    public function show($id): JsonResponse
    {
        $order = Order::query()->with('order_details', 'customer')->find($id);

        return $this->sendApiResponse($order);
    }
}
