<?php

namespace App\Http\Controllers\API\V1\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\MerchantOrderResource;
use App\Models\OrderNote;
use App\Models\Shop;
use App\Models\Product;
use App\Services\Sms;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with('order_details', 'pricing')
            ->where('shop_id', $request->header('shop-id'))
            ->orderByDesc('id')
            ->get();

        if (!$orders) {
            return $this->sendApiResponse('', 'Orders not found', 'NotFound');
        }
        return $this->sendApiResponse(MerchantOrderResource::collection($orders));

    }

    public function order($id): JsonResponse
    {
        $orders = Order::with('order_details', 'customer')
            ->where('id', $id)
            ->firstOrFail();

        if (!$orders) {
            return $this->sendApiResponse('', 'Orders not found', 'NotFound');
        }
        return $this->sendApiResponse($orders);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    public function store(OrderRequest $request): JsonResponse
    {
        return DB::transaction(function() use ($request) {

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

            $shop = Shop::query()->where('shop_id', $request->header('shop-id'))->first();

            if (!$shop->sms_balance < 1) {
                $shop->sms_balance = $shop->sms_balance - 1;
                $shop->sms_sent = $shop->sms_sent + 1;
                $shop->save();

                $sms = new Sms();
                $sms->sendSms($request->input('customer_phone'), $order->order_no, $shop->name);
            }

            return $this->sendApiResponse($order, 'Order Created Successfully');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with(['order_details'])->where('id', $id)->where('shop_id', request()->header('shop-id'))->first();
        if (!$order) {
            return $this->sendApiResponse('', 'Order not found');
        }

        $customer = User::query()->where('id', $order->customer_id)->where('role', 'customer')->first();
        if (!$customer) {
            return $this->sendApiResponse('', 'Customer not found');
        }

        $order['customer'] = $customer;
        return $this->sendApiResponse($order);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function order_status_update(OrderRequest $request): JsonResponse
    {
        $order = Order::query()->with('order_details')
            ->where('id', $request->input('order_id'))
            ->where('shop_id', $request->header('shop-id'))
            ->first();
        if (!$order) {
            return $this->sendApiResponse('', 'Order Not Found', 'NotFound');
        }

        $order->order_status = $request->input('status');
        if ($request->input('status') == 'returned') {
            $order->return_order_date = $request->input('return_order_date');
            $order->return_order_note = $request->input('return_order_note');
            foreach ($order->order_details as $details) {
                $details->product->update([
                    'product_qty' => $details->product->product_qty + $details->product_qty
                ]);
            }
        }
        $order->save();

        $shop = Shop::query()->where('shop_id', $request->header('shop-id'))->first();

        if (!$shop->sms_balance < 1) {
            $shop->sms_balance = $shop->sms_balance - 1;
            $shop->sms_sent = $shop->sms_sent + 1;
            $shop->save();

            $sms = new Sms();
            $message = 'Dear ' . $order->customer_name . ' , Your Order No. ' . $order->order_no . ' is ' . $order->order_status . '.Thank you.' . $shop->name . '';
            $sms->sendSms($request->input('customer_phone'), $order->order_no, $shop->name, $message);
        }
        return $this->sendApiResponse($order, 'Order Status Update Successfully');

    }

    public function order_invoice(Request $request): JsonResponse
    {
        $order = Order::with(['order_details', 'customer'])
            ->where('id', $request->header('order-id'))
            ->where('shop_id', $request->header('shop-id'))
            ->first();

        if (!$order) {
            return $this->sendApiResponse('', 'Order Not found', 'NotFound');
        }

        return $this->sendApiResponse($order);
    }

    public function updateFollowup(Request $request, $id): JsonResponse
    {
        $order = Order::query()->find($id);

        $order->update([
            'follow_up_date' => $request->input('follow_up_date') ?: $order->follow_up_date,
            'follow_up_note' => $request->input('follow_up_note') ?: $order->follow_up_note,
        ]);

        return $this->sendApiResponse($order, 'Follow up date updated successfully');
    }

    public function advancePayment(Request $request, $id): JsonResponse
    {
        $order = Order::query()->find($id);
        $order->update([
            'advance' => $request->input('advance')
        ]);
        return $this->sendApiResponse($order, 'Advance payment updated');
    }
}
