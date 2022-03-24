<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Roles;
use App\Models\Groups;
use App\Models\Group_users;
use App\Traits\GetPageCode;
use Illuminate\Http\Request;
use App\Classes\GetGroupAuth;
use App\classes\GetGroupAdmin;
use App\Events\UpdateGroupOwner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GroupUsersRequest;

class GroupUsersController extends Controller
{
    use GetPageCode;

    ###########################################    show members   ########################
    public function show(Group_users $group_user)
    {
        $group_users = User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['role_id'=>Roles::group_member,'group_id'=>$group_user->group_id]))
            ->cursorPaginate(2);

        $page_code = $this->getPageCode($group_users);

        $view = view('users.groups.index_members', compact('group_users'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ###########################################    add admin   ########################
    public function update(Group_users $group_user)
    {
        $this->authorize('owner_admin',[Group_users::class,$group_user]);

        $group_user->update(['role_id'=>Roles::group_admin]);

        return response()->json(['success'=>'you add admin successfully']);
    }

    ###########################################    punish members   ########################
    public function punish(Group_users $group_user)
    {
        $this->authorize('owner_admin',[Group_users::class,$group_user]);

        $group_user->update(['punish'=>Group_users::punished]);

        return response()->json(['success'=>'you punished user successfully']);
    }

    ###########################################    delete members   ########################
    public function destroy(Group_users $group_user)
    {
        $this->authorize('owner_admin',[Group_users::class,$group_user]);

        $group_user->delete();

        return response()->json(['success'=>'you deleted user successfully']);
    }
}
