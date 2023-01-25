<?php

namespace App\Http\Controllers\Merchant\Auth;


use App\Http\Controllers\MerchantBaseController;
use App\Http\Resources\MerchantResource;
use App\Libraries\cPanel;
use App\Http\Requests\Merchant\MerchantRegister;
use App\Models\User;
use App\Models\Shop;
use App\Traits\sendApiResponse;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends MerchantBaseController
{
    use sendApiResponse;
    /**
     * Show the merchant registration page
     *
     * @return Application|Factory|View
     */

    public function index()
    {
        return view('auth.register');
    }

    /**
     * @param $domain
     * @param $dir
     * @return void
     */
    private function create_subdomain($domain, $dir): void
    {

        $cPanel = new cPanel("funne", 'WZLpi[ahyuXf', "srv1");
        try {

            $parameters = [
                'domain' => $domain,
                'rootdomain' => 'funnelliner.com',
                'dir' => $dir,
                'disallowdot' => 1,
            ];
            $result = $cPanel->execute('api2', "SubDomain", "addsubdomain", $parameters);
            return;
        } catch (Exception $exception) {
            return;
        }
    }

    public function register(MerchantRegister $request)
    {

        $data = Arr::except($request->validated(), ['shop_name']);
        $data['role'] = User::MERCHANT;
        $domain = Str::lower(Str::replace(' ','-',  $request->input('shop_name')));
        $shop = Shop::query()->where('domain', $domain)->first();
        if($shop) {
            $new_domain = $domain.mt_rand(11, 99);
        } else {
            $new_domain = $domain;
        }

        try {
            $merchant = User::query()->create($data);

            $merchant->shop()->create([
                'name' => $request->input('shop_name'),
                'domain' => $new_domain,
                'shop_id' => mt_rand(111111, 999999),
            ]);
            $merchant->merchantinfo()->create();
            /*$this->create_subdomain($new_domain . '-dashboard', 'dashboard.funnelliner.com');
            $this->create_subdomain($new_domain . '-web', 'web.funnelliner.com');
            $url = $domain . '-dashboard.funnelliner.com';*/

            $shop = Shop::query()->where('name', $request->input('shop_name'))->first();

            $user = 'FunnelLine';
            $password = 'upm664se';
            $sender_id = 'FunnelLiner';
            $msg = 'Dear '.$data['name'].' ,
Your registration successfully completed. Your Shop ID is '.$shop->shop_id.' .For bKash Payment Reference ID will be '.$shop->shop_id.' .Please pay your registration fee & active this account.

Thank you.

Funnelliner.Com';
            $url2 = "https://mshastra.com/sendurl.aspx";
            $data2 = [
                "user" => $user,
                "pwd" => $password,
                "type" => "text",
                "CountryCode" => "+880",
                "mobileno" => $data['phone'],
                "senderid" => $sender_id,
                "msgtext" => $msg,
            ];
            $ch = curl_init($url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
            $register = curl_exec($ch);
            return redirect()->away('https://dashboard.funnelliner.com');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function merchant_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::query()->with('shop')
            ->where('role', User::MERCHANT)
            ->where('email', $request->input('email'))
            ->orWhere('phone', User::normalizePhone($request->input('email')))
            ->orWhere('phone', $request->input('email'))
            ->first();

        if($user && Hash::check($request->input('password'), $user->password)) {
            $token = $user->createApiToken();
            return $this->sendApiResponse(new MerchantResource($user), 'Successfully logged in', '', ['token' => $token]);
        } else {
            return $this->sendApiResponse('', 'Invalid Credentials', 'Unauthorized');
        }

    }


    public function merchant_logout(): JsonResponse
    {
        $userRemoveToken = auth()->user()->removeApiToken();
        return response()->json(['msg' => $userRemoveToken], 200);

    }
}
