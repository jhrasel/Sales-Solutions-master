<?php

namespace App\Http\Controllers\API\V1\Theme\Multiple;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThemeRequest;
use App\Models\ActiveTheme;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;

class MultiplePageTemplateController extends Controller
{
    public function index()
    {
        try {
            $themes  = Theme::with('multiple_theme_image')->where('type','multiple')->get();
            return response()->json([
                'success' => true,
                'data' =>$themes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>  $e->getMessage(),
            ], 400);
        }
    }

    public function active(ThemeRequest $request)
    {
        try {

            $merchant = User::where('role', 'merchant')->find(auth()->user()->id);
            if (!$merchant) {
                return response()->json([
                    'success' => false,
                    'msg' =>  'Merchant not Found',
                ], 404);
            }

            $theme = Theme::where('id',$request->multiple_theme_id)->where('type','multiple')->first();
            if(!$theme){
                return response()->json([
                    'success' => false,
                    'msg' =>  'Theme not Found',
                ], 404);
            }

            $activeTheme = ActiveTheme::where('shop_id', $merchant->shop->id)->first();
            if (!$activeTheme) {

                $storeActiveTheme = new ActiveTheme();
                $storeActiveTheme->shop_id = $merchant->shop->id;
                $storeActiveTheme->user_id = $merchant->id;
                $storeActiveTheme->landing_theme_id = null;
                $storeActiveTheme->multiple_theme_id =  $request->multiple_theme_id;
                $storeActiveTheme->save(); 
                
            }

            $activeTheme->landing_theme_id = null ;
            $activeTheme->multiple_theme_id = $request->multiple_theme_id;
            $activeTheme->save();

            return response()->json([
                'success' => true,
                'msg' =>   'multiple page template Active Successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' =>   $e->getMessage(),
            ], 400);
        }
    }
}
