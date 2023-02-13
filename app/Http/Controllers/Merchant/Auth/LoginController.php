<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Merchant\MerchantRegister;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class LoginController extends Controller
{

    /**
     * Show the merchant registration page
     *
     * @return Application|Factory|View
     */

    public function index()
    {
        return view('auth.register');
    }

    public function register(MerchantRegister $request)
    {

        $data = Arr::except($request->validated(), ['shop_name', 'domain']);
        $data['role'] = User::MERCHANT;
        $merchant = User::query()->create($data);

        $merchant->shop()->create([
            'name' => $request->input('shop_name'),
            'domain' => $request->input('domain'),
        ]);


        return redirect()->route('thank_you');

    }
}
