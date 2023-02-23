<?php


namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\MerchantBaseController;

use App\Http\Resources\MerchantResource;
use App\Models\User;
use App\Services\Sms;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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

        if ($response->status() == 200) {
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

        if ($user->otp === $request->input('otp')) {
            $user['otp_verified'] = true;
            return $this->sendApiResponse($user, 'Otp has been verified');
        } else {
            return $this->sendApiResponse('', 'Invalid Otp', 'Invalid');
        }
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => ['required'],
            'password' => ['required', 'confirmed', Password::default()]
        ]);

        $merchant = User::query()->where('phone', $request->input('phone'))->first();

        if(!$merchant) {
            return $this->sendApiResponse('', 'No user found associated with this phone', 'NotFound');
        }

        $merchant->update([
            'password' => $request->input('password'),
        ]);

        return $this->sendApiResponse(new MerchantResource($merchant), 'Password has been changed successfully');
    }
}
