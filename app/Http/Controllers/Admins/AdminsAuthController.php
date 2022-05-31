<?php

namespace App\Http\Controllers\Admins;

use App\Events\ResetPassword;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAuthRequest;
use App\Models\Admins;
use Illuminate\Support\Facades\{Auth};
use Illuminate\Http\{Request,RedirectResponse};

class AdminsAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(adminMiddleware())->only('logout');
        $this->middleware('guest:admins')->except('logout');
    }
    ####################################      getlogin      ################################
    public function getLogin():View
    {
        return view('admins.auth.login');
    }

    ####################################      login      ################################
    public function login(Request $request):RedirectResponse
    {
        $credentials=$request->only('email','password');

        if (auth()->guard('admins')->attempt($credentials,$request->filled('remember_me'))) {
            return redirect('admins/dashboard');
        } else{
            return redirect('admins/login')->with(['error'=>'incorrect password or email']);
        }
    }

    ####################################      login      ################################
    public function getPassword():View
    {
        return view('admins.auth.email');
    }

    ####################################      login      ################################
    public function resetPassword(AdminAuthRequest $request):RedirectResponse
    {
        $email = $request->email;
        $admin = Admins::where('email',$email)->first();

        if ($admin != null) {
            event(new ResetPassword($email));
        }else{
            return redirect()->back()->with('error','incorrect email');
        }

        return redirect()->back()->with('success','reset password link is sent to your email');
    }

    ####################################      logout      ################################
    public function logout():RedirectResponse
    {
        Auth::logout();

        return redirect('admins/login');
    }
}
