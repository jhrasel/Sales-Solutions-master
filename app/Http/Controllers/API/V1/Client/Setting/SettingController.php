<?php

namespace App\Http\Controllers\API\V1\Client\Setting;

use App\Http\Controllers\MerchantBaseController;
use App\Http\Requests\MerchantSettingRequest;
use App\Http\Resources\AdvancePaymentResource;
use App\Models\Media;
use App\Models\MerchantInfo;
use App\Models\Shop;
use App\Models\User;
use App\Models\WebsiteSetting;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SettingController extends MerchantBaseController
{
    use sendApiResponse;

    public function business_info(MerchantSettingRequest $request): JsonResponse
    {
        $shop = Shop::with('shop_logo')->where('shop_id', $request->header('shop-id'))->first();
        if (!$shop) {
            return response()->json(['success' => false, 'msg' => 'Shop not Found',], 200);
        }
        return response()->json(['success' => true, 'data' => $shop], 200);
    }


    public function business_info_update(MerchantSettingRequest $request): JsonResponse
    {
            $merchant = User::query()->where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $shop = Shop::query()->where('shop_id', $request->header('shop-id'))->first();
            $shop->name = $request->input('shop_name');
            $shop->address = $request->input('shop_address');
            $shop->shop_id = $request->header('shop-id');
            $shop->shop_meta_title = $request->input('shop_meta_title');
            $shop->shop_meta_description = $request->input('shop_meta_description');
            $shop->save();

            //store shop logo
            if ($request->hasFile('shop_logo')) {

                $mainImageName = time() . '_shop_logo.' . $request->file('shop_logo')->getClientOriginalExtension();

                $request->shop_logo->move(public_path('images'), $mainImageName);
                $media = new Media();
                $media->name = '/images/' . $mainImageName;
                $media->parent_id = $shop->id;
                $media->type = 'shop_logo';
                $media->save();

                $shop['logo'] = $media->name;
            }

            return response()->json([
                'success' => true,
                'msg' => 'merchant setting business information update successfully',
                'data' => $shop,
            ], 200);
    }

    public function owner_info_update(MerchantSettingRequest $request)
    {

        try {
            DB::beginTransaction();
            $merchant = User::where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $merchant->name = $request->owner_name;
            $merchant->email = $request->owner_email;
            $merchant->phone = $request->owner_number;
            $merchant->save();

            $merchantInfo = MerchantInfo::where('user_id', $merchant->id)->first();
            $merchantInfo->address = $request->owner_address;
            $merchantInfo->other_info = $request->owner_other_info;
            $merchantInfo->save();

            $ownerInfo = [
                'owner_name' => $merchant->name,
                'owner_email' => $merchant->email,
                'owner_number' => $merchant->phone,
                'owner_address' => $merchantInfo->address,
                'owner_other_info' => $merchantInfo->other_info,
            ];


            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'merchant setting owner information update successfully',
                'data' => $ownerInfo,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function owner_info(MerchantSettingRequest $request)
    {
        try {
            DB::beginTransaction();
            $merchant = User::where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $merchantInfo = MerchantInfo::where('user_id', $merchant->id)->first();
            if (!$merchantInfo) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant info not found',
                ], 404);
            }

            $ownerInfo = [
                'owner_name' => $merchant->name,
                'owner_email' => $merchant->email,
                'owner_number' => $merchant->phone,
                'owner_address' => $merchantInfo->address,
                'owner_other_info' => $merchantInfo->other_info,
            ];


            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $ownerInfo,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function password_security_update(MerchantSettingRequest $request)
    {
        try {
            DB::beginTransaction();
            $merchant = User::where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            #Match The Old Password
            if (!Hash::check($request->old_password, $merchant->password)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Old Password Doesn\'t match!',
                ], 404);
            }

            #Update the new Password
            User::whereId($merchant->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'merchant setting password update successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }


    public function website_update(MerchantSettingRequest $request)
    {
        try {

            $merchant = User::query()->where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $websiteSetting = WebsiteSetting::query()->where('user_id', $merchant->id)->first();

            if (!$websiteSetting) {
                DB::beginTransaction();
                $web = new WebsiteSetting();
                if ($request->filled('cash_on_delivery')) {
                    $web->cash_on_delivery = $request->input('cash_on_delivery');
                }
                if ($request->filled('invoice_id')) {
                    $web->invoice_id = $request->input('invoice_id');
                }
                if ($request->filled('custom_domain')) {
                    $web->custom_domain = $request->input('custom_domain');
                }
                if ($request->filled('shop_name')) {
                    $web->shop_name = $request->input('shop_name');
                }
                if ($request->filled('shop_address')) {
                    $web->shop_address = $request->input('shop_address');
                }
                if ($request->filled('website_shop_id')) {
                    $web->website_shop_id = $request->input('website_shop_id');
                }

                $web->shop_id = $request->header('shop-id');
                $web->user_id = $request->header('id');
                if ($request->meta_title) {
                    $web->meta_title = $request->meta_title;
                }
                if ($request->meta_description) {
                    $web->meta_description = $request->meta_description;
                }

                $web->save();

                if ($request->hasFile('website_shop_logo')) {
                    $mainImageName = time() . '_website_shop_logo.' . $request->website_shop_logo->extension();
                    $request->website_shop_logo->move(public_path('images'), $mainImageName);
                    $media = new Media();
                    $media->name = '/images/' . $mainImageName;
                    $media->parent_id = $web->id;
                    $media->type = 'website_shop_logo';
                    $media->save();
                    if ($media) {
                        $web['website_shop_logo'] = $media->name;
                    }
                }
                DB::commit();
                return response()->json([
                    'success' => true,
                    'msg' => 'Merchant website setting update successfully',
                    'data' => $web,
                ], 200);
            }

            $oldLogo = $websiteSetting->website_shop_logo;
            DB::beginTransaction();

            if ($request->cash_on_delivery) {
                $websiteSetting->cash_on_delivery = $request->cash_on_delivery;
            }
            if ($request->invoice_id) {
                $websiteSetting->invoice_id = $request->invoice_id;
            }
            if ($request->custom_domain) {
                $websiteSetting->custom_domain = $request->custom_domain;
            }
            if ($request->shop_name) {
                $websiteSetting->shop_name = $request->shop_name;
            }
            if ($request->shop_address) {
                $websiteSetting->shop_address = $request->shop_address;
            }
            if ($request->website_shop_id) {
                $websiteSetting->website_shop_id = $request->website_shop_id;
            }


            $websiteSetting->shop_id = $request->header('shop-id');
            $websiteSetting->user_id = $request->header('id');
            if ($request->meta_title) {
                $websiteSetting->meta_title = $request->meta_title;
            }
            if ($request->meta_description) {
                $websiteSetting->meta_description = $request->meta_description;
            }
            $websiteSetting->save();

            if ($oldLogo) {
                File::delete(public_path($oldLogo->name));
                $oldLogo->delete();
            }


            if ($request->hasFile('website_shop_logo')) {
                $mainImageName = time() . '_website_shop_logo.' . $request->website_shop_logo->extension();
                $request->website_shop_logo->move(public_path('images'), $mainImageName);
                $media = new Media();
                $media->name = '/images/' . $mainImageName;
                $media->parent_id = $websiteSetting->id;
                $media->type = 'website_shop_logo';
                $media->save();
                if ($media) {
                    $websiteSetting['website_shop_logo'] = $media->name;
                }
            }


            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Merchant website setting update successfully',
                'data' => $websiteSetting,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function pixel_update(MerchantSettingRequest $request)
    {

        try {
            DB::beginTransaction();
            $merchant = User::where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $shop = Shop::where('user_id', $merchant->id)->first();
            $shop->shop_id = $request->shop_id;
            $shop->fb_pixel = $request->fb_pixel;
            $shop->c_api = $request->c_api;
            $shop->test_event = $request->test_event;
            $shop->c_status = $request->c_status;
            $shop->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'FB Pixel setting update successfully',
                'data' => $shop,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function domain_verify(MerchantSettingRequest $request)
    {

        try {
            DB::beginTransaction();
            $merchant = User::where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Merchant not Found',
                ], 404);
            }

            $shop = Shop::query()->where('user_id', $merchant->id)->first();
            $shop->shop_id = $request->shop_id;
            $shop->domain_verify = $request->domain_verify;
            $shop->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Domain verify meta update successfully',
                'data' => $shop,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }


    public function domain_request(MerchantSettingRequest $request)
    {

        try {
            DB::beginTransaction();
            $merchant = User::where('role', 'merchant')->find($request->header('id'));
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Merchant not Found',
                ], 404);
            }

            $shop = Shop::where('user_id', $merchant->id)->first();
            $shop->shop_id = $request->shop_id;
            $shop->domain_request = $request->domain_request;
            $shop->domain_status = $request->input('domain_status');
            $shop->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Domain request successfully added.',
                'data' =>    $shop,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 400);
        }
    }

    public function website(): JsonResponse
    {
        $merchant = User::query()->where('role', 'merchant')->find(request()->header('id'));
        if (!$merchant) {
            return response()->json([
                'success' => false,
                'msg' => 'Merchant not Found',
            ], 200);
        }
        $websiteSetting = WebsiteSetting::with('website_shop_logo')->where('user_id', $merchant->id)->first();
        if (!$websiteSetting) {
            return response()->json([
                'success' => false,
                'msg' => 'Website setting not Found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $websiteSetting,
        ], 200);

    }

    public function updateAdvancePaymentStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required'
        ]);

        $shop = WebsiteSetting::query()->where('shop_id', $request->header('shop-id'))->update([
            'advanced_payment' => $request->input('status')
        ]);

        return $this->sendApiResponse('', 'status updated successfully');
    }

    public function getAdvancePaymentStatus(): JsonResponse
    {
        $advanced_pay_status = WebsiteSetting::query()->where('shop_id', request()->header('shop-id'))->first();

        if(!$advanced_pay_status) {
            return $this->sendApiResponse('', 'No data found with this', 'NotFound');
        }
        return $this->sendApiResponse(new AdvancePaymentResource($advanced_pay_status));
    }
}
