<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if(Carbon::now()->setTimezone('Asia/Dhaka')->format('Y-m-d g:i:s') < Carbon::create(2023, 01, 10, 18, 0, 0)->format('Y-m-d g:i:s')) {
    Route::any('{query}', function () {
        return view('comingsoon::comingsoon');
    })->where('query', '.*');
}

Route::get('/ip', function (){
	$ip = request()->headers();
    return $ip;
});

Route::get('/', [\App\Http\Controllers\General\HomeController::class, 'index'])->name('home');
Route::get('/signup', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'index'])->name('merchant.register');
Route::post('/signup/store', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'register'])->name('merchant.register.store');
Route::get('/thank_you', [\App\Http\Controllers\General\HomeController::class, 'thankYou'])->name('thank_you');
