<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait GetFriends
{
    public function getFriends():Builder
    {
        return User::selection()->whereHas('friends_add_auth', fn($q) => $q->friends_add_auth())
            ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends());
    }
}
