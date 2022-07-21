<?php

namespace App\Http\Controllers\Users;

use App\Classes\Group\GroupFactory;
use App\Events\UpdateGroupOwner;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupUsersRequest;
use App\Models\Group_users;
use App\Models\Roles;
use App\Traits\GetAuthInGroup;
use App\Traits\GetPageCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class GroupReqsController extends Controller
{
	use GetPageCode ,GetAuthInGroup;

	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	//#################################     join    ########################################
	public function store(GroupUsersRequest $request):JsonResponse
	{
		try {
			Group_users::firstOrCreate($request->validated() + ['user_id' => Auth::id()]);

			return response()->json(['success' => __('messages.you send it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//#################################      show      ########################################
	public function show(Group_users $group_request):JsonResponse
	{
		try {
			$this->authorize('owner_admin', $group_request);

			$group_reqs = GroupFactory::factory('GroupReq')->get($group_request->group_id, 5);

			$page_code = $this->getPageCode($group_reqs);

			$view = view('users.groups.index_requests', compact('group_reqs'))->render();

			return response()->json(['view' => $view, 'page_code' => $page_code]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//#################################     approve     ########################################
	public function update(Group_users $group_request):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_request->group_id);
			$this->authorize('owner_admin', $group_auth);

			$group_request->update(['role_id' => Roles::group_member, 'status' => Group_users::approved_req]);

			return response()->json(['success' => __('messages.you approve it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//#################################     ignore    ########################################
	public function ignore(Group_users $group_request):JsonResponse
	{
		try {
			$group_auth = $this->getAuthInGroup($group_request->group_id);
			$this->authorize('owner_admin', $group_auth);

			$group_request->update(['status' => Group_users::ignored_req]);

			return response()->json(['success' => __('messages.you ignore it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//#################################     leave     ########################################
	public function destroy(Group_users $group_request):RedirectResponse
	{
		try {
			$this->authorize('owner_admin_member', $group_request);

			if ($group_request->role_id == Roles::group_owner) {
				$group_admin = GroupFactory::factory('GroupAdmin')->getAdmin($group_request->group_id);

				if ($group_admin) {
					event(new UpdateGroupOwner($group_admin));
				} else {
					return redirect()->back()->with('error', 'you should add admin before leaving');
				}
			}

			$group_request->delete();

			return redirect()->back()->with('success', __('messages.you left it successfully'));
		} catch (\Exception) {
			return redirect()->back()->with('error', 'something went wrong');
		}
	}
}
