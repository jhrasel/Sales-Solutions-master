<?php


namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\MerchantBaseController;

use App\Models\User;
use App\Services\Sms;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgetPasswordController extends MerchantBaseController
{
    use sendApiResponse;

    public function forgetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required'
        ]);
        $user = User::query()->where('role', User::MERCHANT)
            ->where('phone', User::normalizePhone($request->input('phone')))
            ->orWhere('phone', User::removeCode($request->input('phone')))
            ->first();

        if (!$user) {
            return $this->sendApiResponse('', 'No account found with this phone', 'NotFound');
        }

        $send = new Sms();
        $response = $send->sendOtp($user);

        if($response->status() == 200) {
            return $this->sendApiResponse('', 'Otp Has been send to the number you provided');
        } else {
            return $this->sendApiResponse('', 'Something went wrong', 'SomethingWrong');
        }
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);
        $user = User::query()->where('role', User::MERCHANT)
            ->where('phone', User::normalizePhone($request->input('phone')))
            ->orWhere('phone', User::removeCode($request->input('phone')))
            ->first();

        if($user->otp === $request->input('otp')) {
            $send = new Sms();
            $response = $send->sendNewPass($user);

            if($response->status() == 200) {
                return $this->sendApiResponse('', 'Password Has been Changed and send to your phone');
            } else {
                return $this->sendApiResponse('', 'Something went wrong', 'SomethingWrong');
            }
        } else {
            return $this->sendApiResponse('', 'Invalid Otp', 'Invalid');
        }
    }
}
