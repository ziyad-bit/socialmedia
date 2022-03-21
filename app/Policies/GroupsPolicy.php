<?php

namespace App\Policies;

use App\Classes\GetGroupReq;
use App\Models\Group_users;
use App\Models\User;
use App\Models\Roles;
use App\Models\Groups;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupsPolicy
{
    use HandlesAuthorization;

    public function store_requests(User $user , Groups $group):Response
    {
        $group_req=GetGroupReq::getGroupReq($group);

        return  !$group_req ? Response::allow() : Response::deny('something went wrong');
    }

}
