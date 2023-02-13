<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\AdminBaseController;

class DashboardController extends AdminBaseController
{
    public function index()
    {
        return view('panel.dashboard');
    }
}
