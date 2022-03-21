<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
use App\Models\Group_users;
use App\Classes\GetGroupAuth;
use App\Classes\GetGroupUser;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class Group_usersPolicy
{
    use HandlesAuthorization;

    public function owner_admin(User $user , object $group_user):Response
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_user);
        return  $group_auth->role_id === Roles::group_owner || $group_auth->role_id === Roles::group_admin ? Response::allow() : Response::deny('something went wrong');
    }

    public function owner_admin_member(User $user , object $group_user):Response
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_user);
        return  $group_auth->role_id !== null ? Response::allow() : Response::deny('something went wrong');
    }

    public function not_punished(User $user , object $group_user):Response
    {
        return  $group_user->punish !== Group_users::punished ? Response::allow() : Response::deny('something went wrong');
    }
}
