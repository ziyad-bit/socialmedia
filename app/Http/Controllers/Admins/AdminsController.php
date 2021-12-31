<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MembersRequest;
use App\Models\Admins;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    ####################################      getlogin      ################################
    public function getLogin():View
    {
        return view('admins.auth.login');
    }

    ####################################      login      ################################
    public function login(Request $request):RedirectResponse
    {
        $credentials=$request->only('email','password');
        
        if (auth()->guard('admins')->attempt($credentials)) {
            return redirect('admins/dashboard');
        } else{
            return redirect('admins/login')->with(['error'=>'incorrect password or email']);
        }
    }

    ####################################      login      ################################
    public function index():view
    {
        $admins=Admins::paginate(4);
        return view('admins.admin.index',compact('admins'));
    }

    ####################################      create      ################################
    public function create():view
    {
        return view('admins.admin.create');
    }

    ####################################      store      ################################
    public function store(MembersRequest $request):RedirectResponse
    {
        Admins::create($request->except('password','photo_id') + [
                'password'=>Hash::make($request->password)
            ]);

        return redirect()->back()->with('success','you created admin successfully');
    }
}
