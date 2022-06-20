<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use App\Models\Posts;
use App\Models\Admins;
use App\Models\Comments;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins' );
    }

    ####################################      index      ################################
    public function index()
    {
        $users    = User::all()->count();
        $admins   = Admins::all()->count();
        $posts    = Posts::all()->count();
        $comments = Comments::all()->count();

        return view('admins.auth.dashboard',compact('users','admins','posts','comments'));
    }
}
