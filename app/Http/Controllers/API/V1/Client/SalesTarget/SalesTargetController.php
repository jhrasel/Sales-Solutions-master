<?php

namespace App\Http\Controllers\API\V1\Client\SalesTarget;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesTargetRequest;
use App\Models\SalesTarget;
use App\Models\User;
use App\Traits\sendApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


class SalesTargetController extends Controller
{
    use sendApiResponse;

    public function sales_target(): JsonResponse
    {
        $salesTarget = SalesTarget::query()->where('user_id', auth()->user()->id)->first();
        if (!$salesTarget) {
            return $this->sendApiResponse('', 'Sales target not available right now', 'NotAvailable');
        }

        return $this->sendApiResponse($salesTarget);

    }

    public function sales_target_update(SalesTargetRequest $request): JsonResponse
    {
        $salesTarget = SalesTarget::query()->updateOrCreate([
            'user_id' => auth()->id(),
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
