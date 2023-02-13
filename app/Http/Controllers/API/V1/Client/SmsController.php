<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\Controller;
use App\Services\Sms;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class SmsController extends Controller
{

     //send message to single users
    public function single_sms_send(Request $request): JsonResponse
    {
 	
        $request->validate([
            'msg' => 'required',
            'phone' => 'required|min:10'
        ]);

        $shop = Shop::where('shop_id', auth()->user()->shop->shop_id)->first();

        if ($shop->sms_balance < 1) {

            return $this->sendApiResponse('Insufficient Balance!', 'Insufficient Balance!');

        } else {
            $shop->sms_balance = $shop->sms_balance - 1;
            $shop->sms_sent = $shop->sms_sent + 1;
            $shop->save();


            $user = '20102107';
            $password = 'SES@321';
            $sender_id = 'INFOSMS';
            $msg = $request->input('msg');
            $url2 = "https://mshastra.com/sendurl.aspx";
            $data2 = [
                "user" => $user,
                "pwd" => $password,
                "type" => "text",
                "CountryCode" => "+880",
                "mobileno" => $request->input('phone'),
                "senderid" => $sender_id,
                "msgtext" => $msg,
            ];

            $ch = curl_init($url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
            $shop = curl_exec($ch);
        }

        return $this->sendApiResponse($shop, 'SMS has been sent Successfully');
    }
	//send message to multiple users
    public function multiple_sms_send(Request $request): JsonResponse
    {
 	
        $request->validate([
            'msg' => 'required',
            'phone' => 'required|min:10'
        ]);

        $shop = Shop::where('shop_id', auth()->user()->shop->shop_id)->first();

        if ($shop->sms_balance < 1) {

            return $this->sendApiResponse('Insufficient Balance!', 'Insufficient Balance!');

        } else {
            $shop->sms_balance = $shop->sms_balance - 1;
            $shop->sms_sent = $shop->sms_sent + 1;
            $shop->save();

            $user = '20102107';
            $password = 'SES@321';
            $sender_id = 'INFOSMS';
            $msg = $request->input('msg');
            $url2 = "https://mshastra.com/sendurlcomma.aspx";
            $data2 = [
                "user" => $user,
                "pwd" => $password,
                "type" => "text",
                "CountryCode" => "+880",
                "mobileno" => $request->input('phone'),
                "senderid" => $sender_id,
                "msgtext" => $msg,
		"smstype" => "4",
            ];

            $ch = curl_init($url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
            $shop = curl_exec($ch);
        }

        return $this->sendApiResponse($shop, 'SMS has been sent Successfully');
    }
}    