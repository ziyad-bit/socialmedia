<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admins');
	}

	//###################################      index      ################################
	public function index():View
	{
		$users = User::cursorPaginate(5);

		return view('admins.User.index', compact('users'));
	}

	//###################################      create      ################################
	public function create():View
	{
		return view('admins.user.create');
	}

	//###################################      store      ###############################
	public function store(UsersRequest $request):RedirectResponse
	{
		User::create($request->validated());

		return redirect()->back()->with('success', 'you added user successfully');
	}

	//###################################      edit email     ###############################
	public function edit(User $admins_user):View
	{
		return view('admins.user.edit', compact('admins_user'));
	}

	//###################################      update      ###############################
	public function update(UsersRequest $request, User $admins_user):RedirectResponse
	{
		$admins_user->update($request->only('email'));

		return redirect()->back()->with('success', 'you updated user successfully');
	}

	//###################################      edit password    ###############################
	public function editPassword(User $admins_user):View
	{
		return view('admins.user.edit_password', compact('admins_user'));
	}

	//###################################      update password     ###############################
	public function updatePassword(UsersRequest $request, User $admins_user):RedirectResponse
	{
		$admins_user->update($request->only('password'));

		return redirect()->back()->with('success', 'you updated user successfully');
	}

	//###################################      destroy      ###############################
	public function destroy(User $admins_user):RedirectResponse
	{
		$admins_user->delete();

		return redirect()->back()->with('success', 'you deleted user successfully');
	}
}
