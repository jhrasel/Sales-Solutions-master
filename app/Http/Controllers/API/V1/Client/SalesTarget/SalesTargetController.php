<?php

namespace App\Http\Controllers\API\V1\Client\SalesTarget;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesTargetRequest;
use App\Models\Order;
use App\Models\SalesTarget;
use App\Models\User;
use App\Traits\sendApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


class SalesTargetController extends Controller
{
    use sendApiResponse;

    public function sales_target(): JsonResponse
    {
        $amounts = [
            'daily_total' => 0,
            'monthly_total' => 0,
            'custom_total' => 0,
        ];
        $salesTarget = SalesTarget::query()->where('shop_id', request()->header('shop-id'))->first();
        if (!$salesTarget) {
            return $this->sendApiResponse('', 'Sales target not available right now', 'NotAvailable');
        }

        $daily = Order::query()->where('order_status', 'confirmed')
            ->where('updated_at', Carbon::today())
            ->each(function ($query) use (&$amounts){
                $amounts['daily_total'] += $query->grand_total;
            });
        $monthly = Order::query()->where('order_status', 'confirmed')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->each(function ($query) use (&$amounts){
                $amounts['monthly_total'] += $query->grand_total;
            });

        $custom = Order::query()->where('order_status', 'confirmed')
            ->whereBetween('updated_at', [$salesTarget->from_date, $salesTarget->to_date])
            ->each(function ($query) use (&$amounts){
                $amounts['custom_total'] += $query->grand_total;
            });

        $salesTarget['daily_completed'] = number_format((($amounts['daily_total'] / $salesTarget->daily) * 100), 2);
        $salesTarget['monthly_completed'] = number_format((($amounts['monthly_total'] / $salesTarget->monthly) * 100), 2);
        $salesTarget['custom_completed'] = number_format((($amounts['custom_total'] / $salesTarget->custom) * 100), 2);
        $salesTarget['amounts'] = $amounts;
        return $this->sendApiResponse($salesTarget);

    }

    public function sales_target_update(SalesTargetRequest $request): JsonResponse
    {
        $salesTarget = SalesTarget::query()->updateOrCreate([
            'user_id' => $request->header('id'),
            'shop_id' => $request->header('shop-id')
        ], [
            'daily' => $request->input('daily'),
            'monthly' => $request->input('monthly'),
            'custom' => $request->input('custom'),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
        ]);
        return $this->sendApiResponse($salesTarget, 'Sales target updated successfully');

    }
}
