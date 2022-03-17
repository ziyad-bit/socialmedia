<?php

namespace App\Classes;

use App\Models\Roles;
use App\Models\Group_users;

class GetGroupAdmin
{
    public static function getGroupAdmin($group_req):Group_users|null
    {
        return Group_users::where('group_id',$group_req->group_id)->where('role_id',Roles::group_admin)->first();
    }
}
