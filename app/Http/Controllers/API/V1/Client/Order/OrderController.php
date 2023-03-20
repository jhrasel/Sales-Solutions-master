<?php

namespace App\Http\Controllers\API\V1\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\InvoiceOrderResource;
use App\Http\Resources\MerchantOrderResource;
use App\Models\OrderDate;
use App\Models\OrderNote;
use App\Models\OrderPricing;
use App\Models\Shop;
use App\Models\Product;
use App\Models\WebsiteSetting;
use App\Services\Sms;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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
    public function create(): Response
    {
        //
    }


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
            $grand_total = $grand_total + $shipping_cost;
            $order->pricing()->create([
                'shipping_cost' => $shipping_cost,
                'grand_total' => $grand_total,
                'due' => $grand_total,
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

            return $this->sendApiResponse(new MerchantOrderResource($order), 'Order Created Successfully');
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
        $order = Order::query()->with('order_details', 'pricing')
            ->where('id', $id)
            ->where('shop_id', request()->header('shop-id'))
            ->first();
        if (!$order) {
            return $this->sendApiResponse('', 'Order not found');
        }

        return $this->sendApiResponse(new MerchantOrderResource($order));

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
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $order = Order::query()->with('order_details', 'pricing')->find($id);
            $order->update([
                'customer_name' => $request->input('customer_name'),
                'phone' => $request->input('customer_phone'),
                'address' => $request->input('customer_address'),
            ]);

            $grand_total = $order->pricing->grand_total;
            $due = $order->pricing->due;

            if ($request->input('product_id') != null) {
                foreach ($request->input('product_id') as $key => $item) {

                    $product = Product::query()->find($item);

                    $order->order_details()->create([
                        'product_id' => $item,
                        'product_qty' => $request->input('product_qty')[$key],
                        'unit_price' => $product->price,
                    ]);

                    $grand_total += $product->price;
                    $due += $product->price;

                }
            }

            if ($request->filled('shipping_cost')) {
                $grand_total += $request->input('shipping_cost');
                $order->pricing()->update([
                    'grand_total' => $grand_total,
                    'due' => $due,
                    'shipping_cost' => $request->input('shipping_cost'),
                ]);
            }

            return $this->sendApiResponse(new MerchantOrderResource($order));
        });
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

    /**
     * @param OrderRequest $request
     * @return JsonResponse
     * @property string $order_status
     */
    public function order_status_update(OrderRequest $request): JsonResponse
    {
        $order = Order::query()->with('order_details')
            ->where('id', $request->input('order_id'))
            ->where('shop_id', $request->header('shop-id'))
            ->first();
        if (!$order) {
            return $this->sendApiResponse('', 'Order Not Found', 'NotFound');
        }

        if ($request->input('status') === Order::CONFIRMED) {
            $order->order_status = $request->input('status');
        }
        if ($request->input('status') === Order::FOLLOWUP) {
            $order->order_status = $request->input('status');
        }
        if ($request->input('status') === Order::CANCELLED) {
            $order->order_status = $request->input('status');
        }
        if ($request->input('status') === Order::RETURNED) {
            $order->order_status = $request->input('status');
        }
        if ($request->input('status') === Order::SHIPPED) {
            $order->order_status = $request->input('status');
        }
        if ($request->input('status') === Order::DELIVERED) {
            $order->order_status = $request->input('status');
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
        return $this->sendApiResponse(new MerchantOrderResource($order), 'Order Status Update to Successfully');

    }

    public function order_invoice(Request $request): JsonResponse
    {
        $order = Order::query()->with('order_details')
            ->where('id', $request->header('order-id'))
            ->where('shop_id', $request->header('shop-id'))
            ->first();

        $shop = WebsiteSetting::query()->where('shop_id', $request->header('shop-id'))->first();

        $order['shop'] = $shop;
        if (!$order) {
            return $this->sendApiResponse('', 'Order Not found', 'NotFound');
        }

        return $this->sendApiResponse(new InvoiceOrderResource($order));
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
        $order = Order::query()->with('order_details', 'pricing')->find($id);
        $order->pricing->update([
            'due' => abs($order->pricing->grand_total - $request->input('advanced')),
            'advanced' => $request->input('advanced')
        ]);
        return $this->sendApiResponse(new MerchantOrderResource($order), 'Advance payment updated');
    }

    public function noteUpdateByStatus(Request $request, $id): JsonResponse
    {
        $type = $this->checkStatusValidity($request->input('type'));
        if ($type === false) {
            return $this->sendApiResponse('', 'Please add valid Status type');
        }
        $note = OrderNote::query()->updateOrCreate([
            'order_id' => $id,
            'type' => $type
        ], [
            'note' => $request->input('note'),
        ]);

        return $this->sendApiResponse($note, 'Note updated for ' . $request->input('type') . ' order');
    }

    public function dateUpdateByStatus(Request $request, $id): JsonResponse
    {
        $type = $this->checkStatusValidity($request->input('type'));
        if ($type === false) {
            return $this->sendApiResponse('', 'Please add valid Status type');
        }
        $note = OrderDate::query()->updateOrCreate([
            'order_id' => $id,
            'type' => $type
        ], [
            'date' => $request->input('date'),
        ]);

        return $this->sendApiResponse($note, 'Date updated for ' . $type . ' order');
    }


    public function updateDiscount(Request $request, $id): JsonResponse
    {
        $order_pricing = OrderPricing::query()->where('order_id', $id)->first();

        if (Str::contains($request->input('discount'), '%')) {

            $discount = Str::replace('%', '', $request->input('discount'));
            $type = Order::PERCENT;
            $amount = ceil($order_pricing->grand_total - ($order_pricing->grand_total * ($discount / 100)));
            $due = ceil($amount - $order_pricing->advanced);

        } else {
            $discount = $request->input('discount');
            $type = Order::AMOUNT;
            $amount = ceil($order_pricing->grand_total - $request->input('discount'));
            $due = ceil($amount - $order_pricing->advanced);
        }

        $order_pricing->update([
            'discount' => $discount,
            'discount_type' => $type,
            'due' => $due,
        ]);

        return $this->sendApiResponse($order_pricing, 'Discount added successfully');
    }

    public function delete($id): JsonResponse
    {
        $order = Order::query()->find($id);
        $order->delete();
        return $this->sendApiResponse('', 'Order deleted successfully');

    }

    /**
     * @param $value
     * @return string
     */
    public function checkStatusValidity($value): string
    {
        if ($value === Order::PENDING) {
            return Order::PENDING;
        }
        if ($value === Order::CONFIRMED) {
            return Order::CONFIRMED;
        }
        if ($value === Order::FOLLOWUP) {
            return Order::FOLLOWUP;
        }
        if ($value === Order::CANCELLED) {
            return Order::CANCELLED;
        }
        if ($value === Order::RETURNED) {
            return Order::RETURNED;
        }
        if ($value === Order::SHIPPED) {
            return Order::SHIPPED;
        }
        if ($value === Order::DELIVERED) {
            return Order::DELIVERED;
        }
        return false;
    }
}
