<?php

namespace App\Http\Controllers\Admins;

use App\Events\ResetPassword;
use App\Events\UpdatePasswordEvent;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAuthRequest;
use App\Models\Admins;
use App\Models\Password_reset;
use Illuminate\Support\Facades\{Auth};
use Illuminate\Http\{Request,RedirectResponse};

class AdminsAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins' )->only('logout');
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

    ####################################      getresetPasswordLink      ################################
    public function getresetPasswordLink():View
    {
        return view('admins.auth.email');
    }

    ####################################      sendResetPasswordLink      ################################
    public function sendResetPasswordLink(AdminAuthRequest $request):RedirectResponse
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

    ####################################      updatePassword      ################################
    public function updatePassword(AdminAuthRequest $request):RedirectResponse
    {
        $email              = $request->email;
        $password_reset_ins = Password_reset::where(['token'=>$request->token,'email'=>$email])->first();

        if ($password_reset_ins != null) {
            event(new UpdatePasswordEvent($email,$request->password));
        }else{
            return redirect()->back()->with('error','incorrect email');
        }

        return redirect()->back()->with('success','you updated your password successfully');
    }

    ####################################      editPassword      ################################
    public function editPassword():View
    {
        return view('admins.auth.edit_password');
    }

    ####################################      logout      ################################
    public function logout():RedirectResponse
    {
        Auth::logout();

        return redirect('admins/login');
    }
}
