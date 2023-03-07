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


Route::get('/', [\App\Http\Controllers\General\HomeController::class, 'index'])->name('home');
Route::get('/signup', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'index'])->name('merchant.register');
Route::post('/signup/store', [\App\Http\Controllers\Merchant\Auth\LoginController::class, 'register'])->name('merchant.register.store');
Route::get('/thank_you', [\App\Http\Controllers\General\HomeController::class, 'thankYou'])->name('thank_you');
Route::get('/check-order-courier-status', [\App\Http\Controllers\Admin\CourierController::class, 'checkOrderCourierStatus']);
Route::get('/check-balance', [\App\Http\Controllers\Admin\CourierController::class, 'checkCourierBalance']);
