<?php

namespace App\Classes;

use App\Models\Friends_user;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GetFriendReq
{
    public static function get(int $friend_id):Builder
    {
        $auth_id=Auth::id();

        return Friends_user::where(fn($q)=>$q->where('user_id',$auth_id)->where('friend_id',$friend_id))
        ->orwhere(fn($q)=>$q->where('friend_id',$auth_id)->where('user_id',$friend_id))->first();
    }
}
