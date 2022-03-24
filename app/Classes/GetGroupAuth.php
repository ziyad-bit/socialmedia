<?php

namespace App\Classes;

use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;

class GetGroupAuth
{
    public static function getGroupAuth($group_user):Group_users
    {
        return Group_users::where('group_id',$group_user->group_id)->where('user_id',Auth::id())->firstOrFail();
    }
}
