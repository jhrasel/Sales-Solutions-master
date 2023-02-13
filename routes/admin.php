<?php

use App\Http\Controllers\Admin\Auth\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\ThemeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/clear', function (){
   Artisan::call('optimize');
});

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('check.login');

Route::group(['middleware' => ['auth'], 'prefix' => 'panel'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::group(['prefix' => 'merchants'], function () {
        Route::get('/', [MerchantController::class, 'index'])->name('admin.merchants');
        Route::get('/merchants', [MerchantController::class, 'merchants']);
        Route::get('/statuses', [MerchantController::class, 'statuses']);
        Route::get('/{merchant}', [MerchantController::class, 'show'])->name('admin.merchant.details');
        Route::post('/{merchant}/update-status', [MerchantController::class, 'changeStatus'])->name('admin.merchant.change_status');
        Route::post('/{merchant}/delete', [MerchantController::class, 'destroy'])->name('admin.merchant.delete');
    });


    Route::group(['prefix' => 'staffs'], function () {
        Route::get('/', [StaffController::class, 'index'])->name('admin.staffs');
        Route::get('/create', [StaffController::class, 'create'])->name('admin.staffs.create');
        Route::post('/store', [StaffController::class, 'store'])->name('admin.staffs.store');
        Route::get('/edit/{user}', [StaffController::class, 'edit'])->name('admin.staffs.edit');
        Route::put('/update/{user}', [StaffController::class, 'update'])->name('admin.staffs.update');
        Route::delete('/delete/{user}', [StaffController::class, 'destroy'])->name('admin.staffs.delete');
        Route::post('/update-status', [StaffController::class, 'updateStatus'])->name('admin.staffs.update_status');
    });

    Route::group(['prefix' => 'support-ticket'], function (){
        Route::get('/', [SupportTicketController::class, 'index'])->name('admin.support_ticket');
        Route::get('/tickets', [SupportTicketController::class, 'tickets']);
        Route::get('/{uuid}', [SupportTicketController::class, 'show']);
        Route::get('/details/{uuid}', [SupportTicketController::class, 'getTicketDetails']);
        Route::post('/store', [SupportTicketController::class, 'store']);
        Route::post('/reply/{id}', [SupportTicketController::class, 'replyToTicket']);
    });

    Route::group(['prefix' => 'themes'], function () {
        Route::get('/',[ThemeController::class, 'index'])->name('admin.themes');
        Route::get('/list', [ThemeController::class, 'getThemes']);
        Route::post('/store', [ThemeController::class, 'store']);
    });

    Route::get('download/{id}/attachment/',[SupportTicketController::class, 'download']);
});
