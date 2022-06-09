<?php

namespace App\Traits;

use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;

trait GetAuthInGroup
{
    public function getAuthInGroup(int $group_id):Group_users
    {
        return Group_users::where('group_id',$group_id)->where('user_id',Auth::id())->firstOrFail();
    }
}
