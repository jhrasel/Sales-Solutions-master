<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourierProviderRequest;
use App\Http\Resources\CourierOrderResource;
use App\Http\Resources\MerchantOrderResource;
use App\Models\CourierStatus;
use App\Models\MerchantCourier;
use App\Models\Order;
use App\Services\Courier;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourierController extends Controller
{
    use sendApiResponse;

    public function index(Request $request): JsonResponse
    {
        $couriers = MerchantCourier::query()->where('shop_id', $request->header('shop-id'))->get();

        if($couriers->isEmpty()) {
            return $this->sendApiResponse('', 'No data available', 'NotAvailable');
        }
        return $this->sendApiResponse($couriers);
    }

    public function store(CourierProviderRequest $request): JsonResponse
    {
        $courier = MerchantCourier::query()
            ->where('shop_id', $request->header('shop-id'))
            ->where('provider', $request->input('provider'))
            ->first();

        if (!$courier) {
            $courier = MerchantCourier::query()->create([
                'shop_id' => $request->header('shop-id'),
                'provider' => $request->input('provider'),
                'status' => $request->input('status'),
                'config' => $request->input('config'),
            ]);
        } else {
            $courier->update([
                'status' => $request->input('status'),
                'config' => $request->input('config'),
            ]);
        }
        return $this->sendApiResponse($courier, 'Provider Updated Successfully');

    }

    public function sendOrderToCourier(Request $request): JsonResponse
    {
        $request->validate([
            'provider' => 'required',
            'order_id' => 'required',
        ]);
        $courier = MerchantCourier::query()
            ->where('shop_id', $request->header('shop-id'))
            ->where('provider', $request->input('provider'))
            ->where('status', 'active')
            ->first();

        if (!$courier) {
            throw ValidationException::withMessages([
                'notfound' => 'Invalid provider or merchant',
            ]);
        }
        $credentials = collect(json_decode($courier->config))->toArray();

        $data = Order::query()->with('order_details', 'pricing', 'courier', 'config')->where('id', $request->input('order_id'))->first();

        if ($data && $request->input('provider') == MerchantCourier::STEADFAST) {
            $provider = new Courier;
            $response = $provider->createOrder($credentials, $data)->json();

            if($response['status'] === 200) {
                $data->courier->update([
                    'tracking_code' => $response['consignment']['tracking_code'],
                    'status' => $response['consignment']['status']
                ]);
                $data->config->update([
                    'courier_entry' => true
                ]);
                return $this->sendApiResponse(new MerchantOrderResource($data), 'Order has been send to '. MerchantCourier::STEADFAST);
            } else {
                return $this->sendApiResponse('', $response['errors']['invoice'][0], 'AlreadyTaken');
            }
        }

        return $this->sendApiResponse('', 'Order Not found', 'NotFound');

    }

    public function trackOrder(Request $request, $id): JsonResponse
    {
        $order = Order::query()->with('courier', 'order_details', 'pricing', 'config')->find($id);
        $courier = new Courier;
        $merchant_courier = MerchantCourier::query()
            ->where('shop_id', $request->header('shop-id'))
            ->where('provider', $request->input('provider'))
            ->where('status', 'active')
            ->first();

        if($merchant_courier->provider === MerchantCourier::STEADFAST) {

            $credentials = collect(json_decode($merchant_courier->config))->toArray();
            if ($request->filled('tracking_code')) {
                $response = $courier->trackOrder($credentials, '/status_by_trackingcode/' . $request->input('tracking_code'));
                $status = json_decode($response->body());


                if($order->courier->status !== $status->delivery_status) {
                    $order->courier->update([
                        'status' => $status->delivery_status
                    ]);

                    CourierStatus::query()->create([
                        'order_id' => $order->id,
                        'status' => $status->delivery_status,
                    ]);

                    return $this->sendApiResponse(new MerchantOrderResource($order), 'Courier data Updated');
                }
                $status->delivery_status = Courier::status($status->delivery_status);
                return $this->sendApiResponse($status);
            }

        }

        return $this->sendApiResponse('', 'Courier data not found', 'NotFound');

    }
}
