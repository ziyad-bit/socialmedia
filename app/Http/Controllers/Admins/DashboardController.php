<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins' );
    }

    ####################################      index      ################################
    public function index()
    {
        return view('admins.auth.dashboard');
    }
}
