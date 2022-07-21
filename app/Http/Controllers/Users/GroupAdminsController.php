<?php

namespace App\Http\Controllers\Users;

use App\Classes\Group\GroupFactory;
use App\Http\Controllers\Controller;
use App\Models\Group_users;
use App\Models\Roles;
use App\Traits\GetAuthInGroup;
use App\Traits\GetPageCode;
use Illuminate\Http\JsonResponse;

class GroupAdminsController extends Controller
{
	use GetPageCode ,GetAuthInGroup;

	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	//##########################################      show        ########################
	public function show(Group_users $group_admin):JsonResponse
	{
		try {
			$this->authorize('owner_admin_member', $group_admin);

			$group_auth   = $group_admin;
			$group_admins = GroupFactory::factory('GroupAdmin')->get($group_admin->group_id, 5);
			$page_code    = $this->getPageCode($group_admins);

			$view = view('users.groups.index_admins', compact('group_admins', 'group_auth'))->render();

			return response()->json(['view' => $view, 'page_code' => $page_code]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//##########################################    remove admin   ########################
	public function update(Group_users $group_admin):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_admin->group_id);
			$this->authorize('owner', $group_auth);

			$group_admin->update(['role_id' => Roles::group_member]);

			return response()->json(['success' => __('messages.you removed admin successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//##########################################    delete    #############################
	public function destroy(Group_users $group_admin):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_admin->group_id);
			$this->authorize('owner', $group_auth);

			$group_admin->delete();

			return response()->json(['success' => __('messages.you deleted it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}
}
