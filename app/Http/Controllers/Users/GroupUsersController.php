<?php

namespace App\Http\Controllers\Users;

use App\Classes\Group\GroupFactory;
use App\Http\Controllers\Controller;
use App\Models\Group_users;
use App\Models\Roles;
use App\Traits\GetAuthInGroup;
use App\Traits\GetPageCode;
use Illuminate\Http\JsonResponse;

class GroupUsersController extends Controller
{
	use GetPageCode , GetAuthInGroup;

	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	//##########################################    show members   ########################
	public function show(Group_users $group_user):JsonResponse
	{
		try {
			$this->authorize('owner_admin_member', $group_user);

			$group_members = GroupFactory::factory('GroupUsers')->get($group_user->group_id, 5);

			$page_code = $this->getPageCode($group_members);

			$view = view('users.groups.index_members', compact('group_members', 'group_user'))->render();

			return response()->json(['view' => $view, 'page_code' => $page_code]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//##########################################    add admin   ########################
	public function update(Group_users $group_user):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_user->group_id);
			$this->authorize('owner_admin', $group_auth);

			$group_user->update(['role_id' => Roles::group_admin]);

			return response()->json(['success' => __('messages.you did it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//##########################################    punish members   ########################
	public function punish(Group_users $group_user):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_user->group_id);
			$this->authorize('owner_admin', $group_auth);

			$group_user->update(['punish' => Group_users::punished]);

			return response()->json(['success' => __('messages.you did it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//##########################################    delete members   ########################
	public function destroy(Group_users $group_user):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_user->group_id);
			$this->authorize('owner_admin', $group_auth);

			$group_user->delete();

			return response()->json(['success' => __('messages.you deleted it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}
}
