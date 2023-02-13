<?php

namespace App\Http\Controllers;


use App\Models\Shop;
use App\Traits\sendApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, sendApiResponse;

    public function __construct(Request $request)
    {
         if ($request->header('shop-id') && $request->header('shop-id') !== null) {
             $shop = Shop::query()->where('shop_id', $request->header('shop-id'))->first();

             if(!$shop) {
                 abort(404, 'Invalid shop id');
             }
             return $request;
         }
         abort(404, 'Please add valid shop id to request headers');

    }

    protected function limit($default = 10): int
    {
        return (int) request()->input('limit', $default);
    }
}
