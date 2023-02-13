<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeControler extends Controller
{
    /**
     * Landing Page
     *
     */
    public function index()
    {
       return view('landing.index');
    }

    public function thankYou()
    {
        return view('landing.thank_you');
    }
}
