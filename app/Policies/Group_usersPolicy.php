<?php

namespace App\Policies;

use App\Models\{Group_users,Roles,User};
use App\Classes\GetGroupAuth;
use Illuminate\Auth\Access\{HandlesAuthorization,Response};

class Group_usersPolicy
{
    use HandlesAuthorization;

    ###############################     owner    ##########################################
    public function owner(User $user , object $group_user):Response
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_user->group_id , $user->id);
        return  $group_auth->role_id === Roles::group_owner  ? Response::allow() : Response::deny('something went wrong');
    }

    ###############################     owner_admin    ##########################################
    public function owner_admin(User $user , object $group_user):Response
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_user->group_id , $user->id);
        return  $group_auth->role_id === Roles::group_owner || $group_auth->role_id === Roles::group_admin ? Response::allow() : Response::deny('something went wrong');
    }

    ###############################     owner_admins_member   ##########################################
    public function owner_admin_member(User $user , object $group_user):Response
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_user->group_id , $user->id);
        return  $group_auth->role_id !== null ? Response::allow() : Response::deny('something went wrong');
    }

    ###############################      not_punished    ##########################################
    public function not_punished(User $user , object $group_user):Response
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_user->group_id , $user->id);
        return  $group_user->punish !== Group_users::punished ? Response::allow() : Response::deny('something went wrong');
    }
}
