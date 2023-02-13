<?php
namespace App\Http\Controllers\API\V1\Client\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\User;

class MerchantCustomerController extends controller
{
    public function getCustomerByMerchant($id)
    {
        $customers = User::query()->where('role', User::CUSTOMER)->whereHas('customer_info', function ($q) use ($id) {
            return $q->where('merchant_id', $id);
        })->get();

        return response()->json(CustomerResource::collection($customers));
    }
}
