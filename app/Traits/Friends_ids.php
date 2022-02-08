<?php

namespace App\Traits;

use App\Models\User;

trait Friends_ids
{
    public function getFriendsIds():array
    {
        return User::whereHas('friends_add_auth', fn($q) => $q->friends_add_auth())
            ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
            ->pluck('id')->toArray();
    }
}
