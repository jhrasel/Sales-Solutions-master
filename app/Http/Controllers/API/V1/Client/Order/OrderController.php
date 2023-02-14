<?php

namespace App\Http\Controllers\API\V1\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Product;
use App\Services\Sms;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Shop;

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
        $orders = Order::with('order_details', 'customer')
            ->where('shop_id', $request->header('shop-id'))
            ->orderByDesc('id')
            ->get();

        if (!$orders) {
            return $this->sendApiResponse('', 'Orders not found', 'NotFound');
        }
        return $this->sendApiResponse($orders);

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(OrderRequest $request)
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
            'user_id' => auth()->user()->id,
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

        $shop = Shop::where('shop_id', auth()->user()->shop->shop_id)->first();

        if ($shop->sms_balance < 1) {

        } else {
            $shop->sms_balance = $shop->sms_balance - 1;
            $shop->sms_sent = $shop->sms_sent + 1;
            $shop->save();


            $user = '20102107';
            $password = 'SES@321';
            $sender_id = 'INFOSMS';
            $msg = 'Dear ' . $request->input('customer_name') . ' , Your Order No. ' . $order->order_no . ' is pending.Thank you.' . auth()->user()->shop->name . '';
            $url2 = "https://mshastra.com/sendurl.aspx";
            $data2 = [
                "user" => $user,
                "pwd" => $password,
                "type" => "text",
                "CountryCode" => "+880",
                "mobileno" => $request->input('customer_phone'),
                "senderid" => $sender_id,
                "msgtext" => $msg,
            ];
            $ch = curl_init($url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
            $order = curl_exec($ch);
        }

        return $this->sendApiResponse($order, 'Order Created Successfully');

    }
    
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $merchant = User::query()->where('role', 'merchant')->find(auth()->user()->id);
        if (!$merchant) {
            return $this->sendApiResponse('', 'Merchant not found');
        }

        $order = Order::with(['order_details'])->where('id', $id)->where('shop_id', $merchant->shop->shop_id)->first();
        if (!$order) {
            return $this->sendApiResponse('', 'Order not found');
        }

        $customer = User::where('id', $order->customer_id)->where('role', 'customer')->first();
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function order_status_update(OrderRequest $request)
    {
        try {

            $merchant = User::where('role', 'merchant')->find(auth()->user()->id);
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $order = Order::with('order_details')->where('id', $request->order_id)->where('shop_id', $merchant->shop->shop_id)->first();
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Order not Found!',
                ], 404);
            }

            $order->order_status = $request->status;
            if ($request->status == 'returned') {
                $order->return_order_date = $request->return_order_date;
                $order->return_order_note = $request->return_order_note;
                foreach ($order->order_details as $details) {
                    $details->product->update([
                        'product_qty' => $details->product->product_qty + $details->product_qty
                    ]);
                }
            }
            $order->save();

            $shop = Shop::where('shop_id', $merchant->shop->shop_id)->first();

            if ($shop->sms_balance < 1) {

            } else {
            $shop->sms_balance = $shop->sms_balance - 1;
            $shop->sms_sent = $shop->sms_sent + 1;
            $shop->save();

            $user = '20102107';
            $password = 'SES@321';
            $sender_id = 'INFOSMS';
            $msg = 'Dear ' . $order->customer_name . ' ,
Your Order No. ' . $order->order_no . ' is ' . $order->order_status . '.
Thank you.

' . $merchant->shop->name . '';
            $url2 = "https://mshastra.com/sendurl.aspx";
            $data2 = [
                "user" => $user,
                "pwd" => $password,
                "type" => "text",
                "CountryCode" => "+880",
                "mobileno" => $order->customer->phone,
                "senderid" => $sender_id,
                "msgtext" => $msg,
            ];
            $ch = curl_init($url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
            $order = curl_exec($ch);
            }
            return response()->json([
                'success' => true,
                'msg' => 'Order Status Update Successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
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
