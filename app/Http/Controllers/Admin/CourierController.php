<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\MerchantOrderResource;
use App\Models\CourierStatus;
use App\Models\MerchantCourier;
use App\Models\Order;
use App\Services\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
