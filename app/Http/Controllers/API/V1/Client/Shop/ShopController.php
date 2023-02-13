<?php

namespace App\Http\Controllers\API\V1\Client\Shop;

use App\Http\Controllers\MerchantBaseController;
use App\Models\ActiveTheme;
use App\Models\Shop;
use App\Traits\sendApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ShopController extends MerchantBaseController
{
    use sendApiResponse;

    public function index(Request $request): JsonResponse
    {
        if ($request->header('domain') && $request->header('domain') !== null) {
            $shop = Shop::query()->where('domain', $request->header('domain'))->first();
            if (!$shop) {
                throw ValidationException::withMessages([
                    'shop_id' => 'domain not found'
                ]);
            }

            $activeTheme = ActiveTheme::query()->join('themes', 'themes.id', '=', 'active_themes.theme_id')
                ->where('active_themes.shop_id', $shop->shop_id)
                ->where('active_themes.type', 'multiple')
                ->first();

            $shop['theme_id'] = NULL;
            if ($activeTheme) {
                $shop['theme_id'] = $activeTheme->name;
            }

            $shop->load('shop_logo');

            return $this->sendApiResponse($shop);
        }

        return $this->sendApiResponse('', 'domain not found', 'DomainNotFound', [], 401);
    }
}
