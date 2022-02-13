<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait Friends_ids
{
    public function getFriendsIds():array
    {
        $friends_ids= User::whereHas('friends_add_auth', fn($q) => $q->friends_add_auth())
            ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
            ->pluck('id')->toArray();

            
        array_unshift($friends_ids,Auth::id());
        return $friends_ids;
    }
}
