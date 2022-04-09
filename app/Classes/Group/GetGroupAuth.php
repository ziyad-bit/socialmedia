<?php

namespace App\Classes\Group;

use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;

class GetGroupAuth
{
    public static function getGroupAuth(int $group_id):Group_users|null
    {
        return Group_users::where('group_id',$group_id)->where('user_id',Auth::id())->first();
    }
}
