<?php

namespace App\Classes\Friends;

use App\Models\User;
use App\Traits\GetFriends;
use App\Models\Friends_user;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\{CursorPaginator,Paginator};

class Friends 
{
    use GetFriends;

    ###############################      fetch     #####################################
    public function fetch(int $user_id,int $items_num):Paginator
    {
        return $this->getFriends($user_id)->simplePaginate($items_num);
    }

    ###############################      fetch ids    #####################################
    public function fetchIds(int $user_id):array
    {
        if (Cache::has('friends_ids_'.$user_id)) {
            return Cache::get('friends_ids_'.$user_id);
        }

        $friends_ids= $this->getFriends($user_id)->pluck('id')->toArray();
        Cache::put('friends_ids_'.$user_id ,$friends_ids,now()->addHours(6));

        return $friends_ids;
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

    ###############################     get Friends By Online Order    ###################################
    public function getByOnlineOrder(int $item_num):Paginator
    {
        $friends_ids=$this->fetchIds(Auth::id());

        $online_users_ids=[];
        foreach ($friends_ids as  $friends_id) {
            if (Cache::has('online_user_'.$friends_id)) {
                $online_users_ids[]=Cache::get('online_user_'.$friends_id);
            }
        }

        $offline_users_ids=array_diff($friends_ids,$online_users_ids);

        User::where('online',1)->whereIn('id',$offline_users_ids)->limit(50)->update(['online'=>0]);
        return User::whereIn('id',$friends_ids)->orderbydesc('online')->simplePaginate($item_num);
    }

    ###############################     get Friends By Online Order    ###################################
    public static function getRequests()
    {
        return User::selection()->with('friends_add_auth:id')
            ->whereHas('friends_add_auth',fn($q)=>$q->where(['status'=>Friends_user::friend_req,'friend_id'=>Auth::id()]))
            ->cursorPaginate(5);
    }

    ###############################        getProfileData      ###################################
    public static function getProfileData(string $name):Collection
    {
        return User::with(['auth_add_friends'=>fn($q)=>$q->authUser(),
            'friends_add_auth'=>fn($q)=>$q->authFriend(),])
            ->where('name',$name)->get();
    }
}
