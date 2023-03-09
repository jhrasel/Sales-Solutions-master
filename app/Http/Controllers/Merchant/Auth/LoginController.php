<?php

namespace App\Http\Controllers\Merchant\Auth;


use App\Http\Controllers\MerchantBaseController;
use App\Http\Resources\MerchantResource;
use App\Libraries\cPanel;
use App\Http\Requests\Merchant\MerchantRegister;
use App\Models\MerchantToken;
use App\Models\User;
use App\Models\Shop;
use App\Services\Sms;
use App\Traits\sendApiResponse;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
		        'sms_balance' => "50",
                'shop_id' => mt_rand(111111, 999999),
            ]);
            $merchant->merchantinfo()->create();
            $sms = new Sms();
            $sms->sendVerifyOtp($merchant);
            $merchant->load('shop');
            return $this->sendApiResponse(new MerchantResource($merchant), 'Account created Successfully, Verify phone to Use our service');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function merchant_login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::query()->with('shop')
            ->where('role', User::MERCHANT)
            ->where('email', $request->input('email'))
            ->orWhere('phone', User::normalizePhone($request->input('email')))
            ->orWhere('phone', User::removeCode($request->input('email')))
            ->first();

        if($user && Hash::check($request->input('password'), $user->password)) {
            $token = $this->generateToken($user->id, $request->header('ipaddress'), $request->header('browsername'));
            return $this->sendApiResponse(new MerchantResource($user), 'Successfully logged in', '', ['token' => $token]);
        } else {
            return $this->sendApiResponse('', 'Unable to sign in with given credentials', 'Unauthorized');
        }

    }


    public function generateToken($merchant, $ip, $browser): string
    {
        $token = Str::random(80);
        $newToken = new MerchantToken();
        $newToken->user_id = $merchant;
        $newToken->token = $token;
        $newToken->ip = $ip;
        $newToken->browser = $browser;
        $newToken->save();
        return $token;
    }

    public function merchant_logout(Request $request)
    {
        try {
            $merchants = MerchantToken::query()->where('user_id', $request->header('id'))
                ->where('ip', $request->header('ipaddress'))
                ->where('browser', $request->header('browsername'))
                ->get();

            foreach ($merchants as $merchant) {
                $merchant->delete();
            }
            return $this->sendApiResponse('', 'Successfully Logout!');

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);
        $user = User::query()->with('shop')
            ->where('role', User::MERCHANT)
            ->where('phone', User::normalizePhone($request->input('phone')))
            ->orWhere('phone', User::removeCode($request->input('phone')))
            ->first();

        if($user->otp === $request->input('otp')) {
            $user->phone_verified_at = now();
            $user->save();

            return $this->sendApiResponse(new MerchantResource($user), 'Account Verification Successful');

        } else {
            return $this->sendApiResponse('', 'Invalid OTP! Please insert valid OTP', 'Invalid');
        }
    }

    public function resendOTP(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::query()->with('shop')
            ->where('role', User::MERCHANT)
            ->where('phone', User::normalizePhone($request->input('phone')))
            ->orWhere('phone', User::removeCode($request->input('phone')))
            ->first();

        $sms = new Sms();
        $sms->sendVerifyOtp($user);
        return $this->sendApiResponse('', 'OTP has been send to given number');
    }

    public function checkIp($ip, $browser): JsonResponse
    {
        $user = MerchantToken::query()->where('ip', $ip)->where('browser', $browser)->first();
        if(!$user) {
            return $this->sendApiResponse('', 'No user token found with this ip');
        }

        return $this->sendApiResponse($user);
    }
}
