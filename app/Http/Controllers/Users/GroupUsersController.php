<?php

namespace App\Http\Controllers\Users;

use App\Models\{Group_users,User,Roles};
use App\Traits\{GetPageCode,GetGroupAuth};
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GroupUsersController extends Controller
{
    use GetPageCode , GetGroupAuth;

    ###########################################    show members   ########################
    public function show(Group_users $group_user):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin_member',$group_auth);

        $group_users = User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['role_id'=>Roles::group_member,'group_id'=>$group_user->group_id]))
            ->cursorPaginate(2);

        $page_code  = $this->getPageCode($group_users);

        $view = view('users.groups.index_members', compact('group_users','group_auth'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ###########################################    add admin   ########################
    public function update(Group_users $group_user):JsonResponse
    {
        $group_auth=$this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_user->update(['role_id'=>Roles::group_admin]);

        return response()->json(['success'=>'you add admin successfully']);
    }

    ###########################################    punish members   ########################
    public function punish(Group_users $group_user):JsonResponse
    {
        $group_auth=$this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_user->update(['punish'=>Group_users::punished]);

        return response()->json(['success'=>'you punished user successfully']);
    }

    ###########################################    delete members   ########################
    public function destroy(Group_users $group_user):JsonResponse
    {
        $group_auth=$this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_user->delete();

        return response()->json(['success'=>'you deleted user successfully']);
    }
}
