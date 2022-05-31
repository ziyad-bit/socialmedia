<?php

namespace App\Http\Controllers\Admins;

use App\Models\Admins;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminsRequest;
use Illuminate\Http\{RedirectResponse};

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware(adminMiddleware());
    }

    ####################################      index      ################################
    public function index():view
    {
        $admins=Admins::cursorPaginate(5);
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
        Admins::create($request->except('photo_id'));

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
        $admin->update($request->except('photo_id'));

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
