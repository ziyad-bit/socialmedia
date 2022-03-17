<?php

namespace App\Policies;

use App\Models\Group_users;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class Group_usersPolicy
{
    use HandlesAuthorization;

    public function show(User $user , Group_users $group_user)
    {
        return  $group_user->role_id === Roles::group_owner || $group_user->role_id === Roles::group_admin ? Response::allow() : Response::deny('something went wrong');
    }

    public function update(User $user , Group_users $group_user)
    {
        $group_req=Group_users::where('group_id',$group_user->group_id)->where('user_id',$user->id)->firstOrFail();

        return  $group_req->role_id === Roles::group_owner || $group_req->role_id === Roles::group_admin ? Response::allow() : Response::deny('something went wrong');
    }

}
