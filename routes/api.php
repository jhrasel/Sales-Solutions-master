<?php

use App\Http\Controllers\API\V1\Client\Category\CategoryController as ClientCategory;
use App\Http\Controllers\API\V1\Client\CourierController;
use App\Http\Controllers\API\V1\Client\Customer\MerchantCustomerController;
use App\Http\Controllers\API\V1\Client\ForgetPasswordController;
use App\Http\Controllers\API\V1\Client\Order\OrderController as ClientOrder;
use App\Http\Controllers\API\V1\Client\Page\PageController;
use App\Http\Controllers\API\V1\Client\Product\ProductController as ClientProduct;
use App\Http\Controllers\API\V1\Client\SalesTarget\SalesTargetController;
use App\Http\Controllers\API\V1\Client\Setting\SettingController as MerchantSetting;
use App\Http\Controllers\API\V1\Client\Slider\SliderController as ClientSlider;
use App\Http\Controllers\API\V1\Client\Stock\Inventory\InventoryController;
use App\Http\Controllers\API\V1\Client\Stock\ProductReturn\ProductReturnController;
use App\Http\Controllers\API\V1\Client\Stock\StockIn\StockInController;
use App\Http\Controllers\API\V1\Client\SupportTicket\SupportTicketController;
use App\Http\Controllers\API\V1\Client\TopSellingProduct\TopSellingProduct;
use App\Http\Controllers\API\V1\Theme\ThemeController;
use App\Http\Controllers\Merchant\Auth\LoginController;
use App\Http\Controllers\API\V1\Client\SmsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




//client api
Route::prefix('v1/customer')->name('customer.')->group(function () {

    Route::get('categories', [\App\Http\Controllers\API\V1\Customer\CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}', [\App\Http\Controllers\API\V1\Customer\CategoryController::class, 'show'])->name('categories.show');

    Route::get('products', [\App\Http\Controllers\API\V1\Customer\ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}', [\App\Http\Controllers\API\V1\Customer\ProductController::class, 'show'])->name('products.show');
    Route::post('products/search', [\App\Http\Controllers\API\V1\Customer\ProductController::class, 'search'])->name('products.search');
    Route::get('top-selling-product', [\App\Http\Controllers\API\V1\Client\TopSellingProduct\TopSellingProduct::class, 'customer_index']);
    
    //Orders
    Route::post('/order/store', [\App\Http\Controllers\API\V1\Customer\OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}/details', [\App\Http\Controllers\API\V1\Customer\OrderController::class, 'show'])->name('order.details');

    

    Route::post('/register', [\App\Http\Controllers\API\V1\Customer\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\API\V1\Customer\AuthController::class, 'login']);
});


//merchant api

Route::group(['prefix' => 'v1'], function () {
    Route::post('/signup', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'register']);
    Route::post('/auth/verify', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'verify']);
    Route::post('/resend/otp', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'resendOTP']);
    Route::post('/shops/info', [\App\Http\Controllers\API\V1\Client\Shop\ShopController::class, 'index']);
    Route::get('/page/{page}', [\App\Http\Controllers\API\V1\PageController::class, 'show']);
    Route::get('/device/{ip}/check/{browser}', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'checkIp']);
});


Route::post('/login', [LoginController::class, 'merchant_login'])->name('merchant.login');

Route::group(['prefix' => 'v1/client'], function () {
    Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('/otp-verify', [ForgetPasswordController::class, 'verifyOtp']);
    Route::get('/themes/list/{page}', [ThemeController::class, 'getListByPage']);
});

Route::prefix('v1/client')->middleware('auth:api')->name('client.')->group(function () {
    Route::get('logout', [LoginController::class, 'merchant_logout'])->name('logout');
    Route::prefix('settings')->name('settings.')->group(function () {

        //business info
        Route::get('business-info', [MerchantSetting::class, 'business_info'])->name('business.info');
        Route::post('business-info/update', [MerchantSetting::class, 'business_info_update'])->name('business.info.update');
        Route::post('pixel/update', [MerchantSetting::class, 'pixel_update'])->name('pixel.update');
        Route::post('domain-meta/update', [MerchantSetting::class, 'domain_verify'])->name('domain.meta.update');
        Route::post('domain/update', [MerchantSetting::class, 'domain_request'])->name('domain.request.update');
        Route::post('/advance-payment/status/update', [MerchantSetting::class, 'updateAdvancePaymentStatus']);
        Route::get('/advance-payment/status', [MerchantSetting::class, 'getAdvancePaymentStatus']);

        //owner info
        Route::get('owner-info', [MerchantSetting::class, 'owner_info'])->name('owner.info');
        Route::post('owner-info/update', [MerchantSetting::class, 'owner_info_update'])->name('owner.info.update');

        //password & security
        Route::post('password-security/update', [MerchantSetting::class, 'password_security_update'])->name('password.security.update');

        //website
        Route::get('website', [MerchantSetting::class, 'website'])->name('website');
        Route::post('website/update', [MerchantSetting::class, 'website_update'])->name('website.update');
    });

    // SMS Send
        Route::post('/single-sms-send', [SmsController::class, 'single_sms_send']);
        Route::post('/multiple-sms-send', [SmsController::class, 'multiple_sms_send']);
    
    // Support ticket
    Route::group(['prefix' => 'support-ticket'], function () {
        Route::post('/list', [SupportTicketController::class, 'index']);
        Route::post('/store', [SupportTicketController::class, 'store']);
        Route::get('/{merchant}/details/{id}', [SupportTicketController::class, 'show']);
        Route::post('/{id}/reply', [SupportTicketController::class, 'reply']);
    });

    Route::get('/customers/{id}', [MerchantCustomerController::class, 'getCustomerByMerchant']);

    Route::resource('categories', ClientCategory::class);
    Route::resource('products', ClientProduct::class);
    Route::resource('orders', ClientOrder::class);
    Route::get('top-selling-product', [TopSellingProduct::class, 'index']);

    Route::get('sales-target', [SalesTargetController::class, 'sales_target'])->name('sales.target');
    Route::post('sales-target/update', [SalesTargetController::class, 'sales_target_update'])->name('sales.target.update');
    Route::post('orders/status/update', [ClientOrder::class, 'order_status_update'])->name('orders.status.update');
    Route::get('/order-invoice', [ClientOrder::class, 'order_invoice'])->name('order.invoice');
    Route::post('/order/follow-up/{id}/update', [ClientOrder::class, 'updateFollowup'])->name('order.follow_up');
    Route::post('/order/advance-payment/{id}/update', [ClientOrder::class, 'advancePayment'])->name('order.advance_pay');

    Route::resource('sliders', ClientSlider::class);
    Route::resource('pages', PageController::class);

    Route::prefix('stocks')->name('stocks.')->group(function () {

        //Inventory
        Route::get('inventory/list', [InventoryController::class, 'index'])->name('inventory.list');
        Route::get('inventory/show/{id}', [InventoryController::class, 'show'])->name('inventory.show');
        Route::post('inventory/update', [InventoryController::class, 'update'])->name('inventory.update');

        //Stock In
        Route::get('stock-in/list', [StockInController::class, 'index'])->name('stock.in.list');
        Route::get('stock-in/show/{id}', [StockInController::class, 'show'])->name('stock.in.show');
        Route::post('stock-in/update', [StockInController::class, 'update'])->name('stock.in.update');

        //Product return
        Route::get('product-return/list', [ProductReturnController::class, 'index'])->name('product.return.list');
        Route::post('product-return/update', [ProductReturnController::class, 'update'])->name('product.return.update');

    });

    Route::group(['prefix' => 'themes'], function () {
        Route::post('/list', [ThemeController::class, 'getThemesByType']);
        Route::post('/import-theme', [ThemeController::class, 'import']);
        Route::post('/merchant/themes', [ThemeController::class, 'getMerchantsTheme']);

        Route::post('/custom/store', [ThemeController::class, 'store']);
        Route::post('/custom/{id}/update', [ThemeController::class, 'update']);
       
    });


    Route::group(['prefix' => 'courier'], function () {

        Route::get('/list', [CourierController::class, 'index']);
        Route::post('/provider', [CourierController::class, 'store']);
        Route::post('/send-order', [CourierController::class, 'sendOrderToCourier']);
        Route::post('/track-order/{id}', [CourierController::class, 'trackOrder']);
    });


});
