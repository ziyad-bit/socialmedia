<?php

namespace App\Classes\Friends;

use App\Models\User;
use App\Traits\GetFriends;
use Illuminate\Pagination\{CursorPaginator,Paginator};
use Illuminate\Support\Facades\Auth;

class Friends 
{
    use GetFriends;

    ###############################      fetch     #####################################
    public function fetch(int $user_id):Paginator
    {
        return $this->getFriends($user_id)->simplePaginate(7);
    }

    ###############################      fetch ids    #####################################
    public function fetchIds(int $user_id):array
    {
        return $this->getFriends($user_id)->pluck('id')->toArray();
    }

    ###############################      fetch  mutual ids    #####################################
    public function fetchMutualIds(int $user_id):array
    {
        $user_friends_ids   = $this->fetchIds($user_id);
        $auth_friends_ids   = $this->fetchIds(Auth::id());

        return  array_intersect($user_friends_ids,$auth_friends_ids);
    }

    ###############################      fetch  mutual     #####################################
    public function fetchMutual(int $user_id,int $items_num):CursorPaginator
    {
        $mutual_friends_ids=$this->fetchMutualIds($user_id);

        return User::selection()->whereIn('id',$mutual_friends_ids)->cursorPaginate($items_num);
    }
}
