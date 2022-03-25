<?php

namespace App\Classes;

use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;

class GetGroupAuth
{
    public static function getGroupAuth(int $group_id , int $user_id):Group_users
    {
        return Group_users::where('group_id',$group_id)->where('user_id',$user_id)->firstOrFail();
    }
}
