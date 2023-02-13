<?php

use App\Http\Controllers\Admin\Auth\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Route;



Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('check.login');

Route::group(['middleware' => ['auth'], 'prefix' => 'panel'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
