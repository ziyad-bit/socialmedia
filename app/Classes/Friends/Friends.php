<?php

namespace App\Classes\Friends;

use App\Traits\GetFriends;
use Illuminate\Pagination\Paginator;

class Friends 
{
    use GetFriends;

    public function fetch():Paginator
    {
        return $this->getFriends()->simplePaginate(7);
    }
}
