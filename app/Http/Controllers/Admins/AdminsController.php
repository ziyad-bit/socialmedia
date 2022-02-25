<?php

namespace App\Http\Controllers\Admins;

use App\Models\Admins;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminsRequest;
use App\Http\Requests\MembersRequest;
use Illuminate\Support\Facades\{Auth,Hash};
use Illuminate\Http\{Request,RedirectResponse};

class AdminsController extends Controller
{
    public function __construct()
    {
        $loginRoutes=['getLogin','login'];
        
        $this->middleware(adminMiddleware())->except($loginRoutes);
        $this->middleware('guest:admins')->only($loginRoutes);
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

    ####################################      logout      ################################
    public function logout():RedirectResponse
    {
        Auth::logout();

        return redirect('admins/login');
    }

    ####################################      index      ################################
    public function index():view
    {
        $admins=Admins::cursorPaginate(pagination);
        return view('admins.admin.index',compact('admins'));
    }

    ####################################      create      ################################
    public function create():view
    {
        return view('admins.admin.create');
    }

    ####################################      store      ################################
    public function store(AdminsRequest $request):RedirectResponse
    {
        Admins::create($request->except('password','photo_id') + [
                'password'=>Hash::make($request->password)
            ]);

        return redirect()->back()->with('success','you created admin successfully');
    }

    ####################################      create      ################################
    public function edit(int $id):view
    {
        $admin=Admins::findOrFail($id);

        return view('admins.admin.edit',compact('admin'));
    }

    ####################################      update      ################################
    public function update(int $id,AdminsRequest $request):RedirectResponse
    {
        $admin=Admins::find($id);
        $admin->update($request->except('password','photo_id') + [
                'password'=>Hash::make($request->password)
            ]);

        return redirect()->back()->with('success','you updated admin successfully');
    }

    ####################################      delete      ################################
    public function delete(int $id):RedirectResponse
    {
        $admin=Admins::find($id);
        $admin->delete();

        return redirect()->back()->with('success','you deleted admin successfully');
    }
}
