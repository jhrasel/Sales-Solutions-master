<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function store(OrderRequest $request): JsonResponse
    {
        $customer = User::query()->firstOrCreate([
            'phone' => $request->input('customer_phone'),
            'role' => User::CUSTOMER
        ], [
            'name' => $request->input('customer_name'),
            'email' => 'customer' . rand(1000, 9999) . '@gmail.com',
            'address' => $request->input('customer_address'),
            'password' => Hash::make(12345678),
        ]);

        $order = Order::query()->create([
            'order_no' => rand(100, 9999),
            'shop_id' => $request->header('shop-id'),
            'customer_id' => $customer->id,
            'address' => $request->input('customer_address')
        ]);

        $grand_total = 0;
        //store order details
        foreach ($request->input('product_id') as $key => $item) {

            $product = Product::query()->find($item);

            $order->order_details()->create([
                'product_id' => $item,
                'product_qty' => $request->input('product_qty')[$key],
            ]);

            $grand_total += $product->price * $request->input('product_qty')[$key];

        }
        $order->grand_total = $grand_total;
        $order->save();

        $order->load('customer', 'order_details');
        foreach ($order->order_details as $details) {
            $details->product->update([
                'product_qty' => $details->product->product_qty - $details->product_qty
            ]);
        }

        return $this->sendApiResponse($order, 'Order Created Successfully');

    }

    public function show($id): JsonResponse
    {
        $order = Order::query()->with('order_details', 'customer')->find($id);

        return $this->sendApiResponse($order);
    }
}
