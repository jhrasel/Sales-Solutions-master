<?php

namespace App\Jobs;

use App\Models\MerchantCourier;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class UpdateOrderCourierStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::query()->where('courier_entry', true)
            ->where('order_status', '!=', 'pending')
            ->orWhere('order_status', '!=', 'cancel')
            ->orWhere('order_status', '!=', 'delivered')
            ->orWhere('consignment_id', '!=', null)
            ->orWhere('tracking_code', '!=', null)
            ->get();

        dd($orders);

        if($orders->isNotEmpty()) {
            foreach ($orders as $order) {
                $check_courier_status = MerchantCourier::query()->where('provider', MerchantCourier::STEADFAST)->first();

            }
        }


    }
}
