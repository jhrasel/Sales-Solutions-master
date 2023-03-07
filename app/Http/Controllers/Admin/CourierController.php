<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\CourierStatus;
use App\Models\MerchantCourier;
use App\Models\Order;
use App\Models\Shop;
use App\Services\Courier;


class CourierController extends AdminBaseController
{
    public function checkOrderCourierStatus(): bool
    {
        $orders = Order::query()->with('order_details', 'courier', 'config', 'pricing')
            ->where(function ($query) {
                $query->where('order_status', '!=', Order::PENDING)
                    ->orWhere('order_status', '!=', Order::CANCELLED)
                    ->orWhere('order_status', '!=', Order::DELIVERED);
            })->whereRelation('courier', 'tracking_code', '!=', null)
            ->get();


        if ($orders->isNotEmpty()) {
            foreach ($orders as $order) {
                $check_courier_status = MerchantCourier::query()->where('provider', MerchantCourier::STEADFAST)
                    ->where('shop_id', $order->shop_id)
                    ->where('config', '!=', null)
                    ->where('status', 'active')
                    ->first();
                $courier = new Courier;
                $credentials = collect(json_decode($check_courier_status->config))->toArray();
                $response = $courier->trackOrder($credentials, '/status_by_trackingcode/' . $order->courier->tracking_code);
                $status = json_decode($response->body());

                if ($order->courier->status !== $status->delivery_status) {
                    $order->courier->update([
                        'status' => $status->delivery_status
                    ]);

                    CourierStatus::query()->create([
                        'order_id' => $order->id,
                        'status' => $status->delivery_status,
                    ]);
                }
            }
            return true;
        }

        return false;
    }

    public function checkCourierBalance(): bool
    {
        $courier_merchants = MerchantCourier::query()->where('provider', MerchantCourier::STEADFAST)
            ->where('config', '!=', null)
            ->where('status', 'active')
            ->get();

        foreach ($courier_merchants as $merchant) {
            $courier = new Courier;
            $credentials = collect(json_decode($merchant->config))->toArray();
            $response = $courier->checkBalance($credentials, '/get_balance');
            $status = json_decode($response->body());

            if($status->status === 200) {
                $shop = Shop::query()->where('shop_id', $merchant->shop_id)->first();
                $shop->update([
                    'courier_balance' => $status->current_balance
                ]);
            }
        }
        return true;
    }
}
