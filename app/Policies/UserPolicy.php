<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Friends_user;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function store(User $user,User $friend)
    {
        $friend_req=Friends_user::where('user_id',$user->id)->where('friend_id',$friend->id)->first();
        return ! $friend_req ? Response::allow() : Response::deny('something went wrong');
    }
}
