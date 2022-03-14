<?php

namespace App\Policies;

use App\Models\Group_users;
use App\Models\User;
use App\Models\Groups;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupsPolicy
{
    use HandlesAuthorization;

    public function show(User $user , Groups $group)
    {
        $group_req=Group_users::where('user_id',$user->id)->where('group_id',$group->id)->first();

        return $user->id === $group->user_id && $group_req ? Response::allow() : Response::deny('something went wrong');
    }
}
