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

   

}
