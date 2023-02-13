<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Sms
{

    public function request(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl('https://mshastra.com')
            ->asJson();
   }

    public function config($otp, $phone, $message = null): string
    {
        if(Str::startsWith($phone, '+88')) {
            $phone = User::removeCode($phone);
        }

        if($message === null) {
            $message = 'Your funnelliner OTP is '.$otp. ' Do not share this with anyone.';
        }

        return 'user=FunnelLine&pwd=upm664se&CountryCode=+880&mobileno='.$phone.'&senderid=FunnelLiner&msgtext='.$message;
    }

    public function sendOtp($user)
    {
        $otp = mt_rand(111111, 999999);
        $user->otp = $otp;
        $user->save();
        $query = $this->config($otp, $user->phone);
        return $this->request()->get('sendurl.aspx', $query);
    }

    public function sendNewPass($user)
    {
        $pass = (string) mt_rand(11111111, 99999999);
        $user->password = $pass;
        $user->save();

        $message = 'Your funnelliner Password is '.$pass. ' Please change it after login.';
        $query = $this->config($pass, $user->phone, $message);
        return $this->request()->get('sendurl.aspx', $query);
    }

    public function sendVerifyOtp($user)
    {
        $otp = mt_rand(111111, 999999);
        $user->otp = $otp;
        $user->save();
        $query = $this->config($otp, $user->phone, null);
        return $this->request()->get('sendurl.aspx', $query);
    }
}
