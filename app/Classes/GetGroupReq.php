<?php

namespace App\Classes;

use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;

class GetGroupReq
{
    public static function getGroupReq($group):Group_users|null
    {
        return Group_users::where('group_id',$group->id)->where('user_id',Auth::id())->first();
    }
}
