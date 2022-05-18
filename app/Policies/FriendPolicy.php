<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Friends_user;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FriendPolicy
{
    use HandlesAuthorization;

    public function update_or_delete(User $user,Friends_user $friend)
    {
        return $user->id === $friend->friend_id || $user->id === $friend->user_id ? Response::allow() : Response::deny('something went wrong');
    }
}
