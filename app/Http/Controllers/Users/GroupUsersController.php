<?php

namespace App\Http\Controllers\Users;

use App\classes\GetGroupAdmin;
use App\Events\UpdateGroupOwner;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupUsersRequest;
use App\Models\Groups;
use App\Models\Group_users;
use App\Models\Roles;
use App\Models\User;
use App\Traits\GetPageCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupUsersController extends Controller
{
    use GetPageCode;

    public function index()
    {
        //
    }

    public function store(GroupUsersRequest $request)
    {
        $group = Groups::findOrFail($request->group_id);
        $this->authorize('store_requests', $group);

        Group_users::create($request->validated() + ['user_id' => Auth::id()]);

        return response()->json(['success' => 'you sent request successfully']);
    }

    public function show(Group_users $group_user)
    {
        $this->authorize('show', $group_user);

        $group_users = User::with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['group_id' => $group_user->group_id, 'group_users.status' => Group_users::join_req]))
            ->selection()->cursorPaginate(3);

        $page_code = $this->getPageCode($group_users);

        $view = view('users.groups.next_requests', compact('group_users'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }


    public function update(Request $request, Group_users $group_user)
    {
        $this->authorize('update',$group_user);

        $group_user->update(['role_id'=>Roles::group_member,'status'=>Group_users::approved_req]);

        return response()->json(['success'=>'you approved request successfully']);
    }

    public function destroy(Group_users $group_user)
    {
        $group_admin = GetGroupAdmin::getGroupAdmin($group_user);

        if ($group_user->role_id == Roles::group_owner) {
            if ($group_admin) {
                event(new UpdateGroupOwner($group_admin));
            } else {
                return redirect()->back()->with('error', 'you should add admin before leaving');
            }
        }

        $group_user->delete();

        return redirect()->back()->with('success', 'you left group successfully');
    }
}
