<?php

namespace App\Classes;

use App\Models\Group_users;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GroupReq
{
    public static function get(int $group_id):Builder
    {
        return Group_users::where('user_id',Auth::id())->where('group_id',$group_id)->first();
    }
}
