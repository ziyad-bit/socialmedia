<?php

namespace App\Classes\Friends;

use App\Traits\GetFriends;

class FriendsIds 
{
    use GetFriends;

    public function fetchIds():array
    {
        return $this->getFriends()->pluck('id')->toArray();
    }
}
