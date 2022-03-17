<?php

namespace App\Policies;

use App\Models\Group_users;
use App\Models\User;
use App\Models\Roles;
use App\Models\Groups;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupsPolicy
{
    use HandlesAuthorization;

    public function store_requests(User $user , Groups $group)
    {
        $group_req=Group_users::where('group_id',$group->id)->where('user_id',$user->id)->first();

        return  !$group_req ? Response::allow() : Response::deny('something went wrong');
    }

    public function show_requests(User $user , Groups $group)
    {
        $group_req=Group_users::where('group_id',$group->id)->where('user_id',$user->id)->first();

        return  $group_req->role_id === Roles::group_owner ? Response::allow() : Response::deny('something went wrong');
    }

    public function destroy(User $user , Groups $group)
    {
        $group_req=Group_users::where('group_id',$group->id)->where('user_id',$user->id)->first();

        return  $group_req->role_id !== null ? Response::allow() : Response::deny('something went wrong');
    }
}
