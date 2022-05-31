<?php

namespace App\Classes\Group;

use App\Interfaces\Group\Get;
use App\Models\Groups;
use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\CursorPaginator;

class Group implements Get
{
    ##############################    get admins   ##################################
    public function get(int $auth_id):CursorPaginator
    {
        return Groups::selection()->whereHas('group_users', fn($q) => $q->where("user_id", $auth_id))
            ->cursorPaginate(10);
    }

    ##############################    get  auth    ##################################
    public function getAuth(int $group_id):Group_users|null
    {
        
        return Group_users::where('group_id',$group_id)->where('user_id',Auth::id())->first();
    }

    ##############################    get users count    ##################################
    public function get_users_count()
    {
        return Groups::whereHas('group_users',fn($q)=>$q->where('role_id','!=',null))->count();
    }

    ##############################    get users count    ##################################
    public  function getJoinedIds():array
    {
        return  Group_users::where('user_id',Auth::id())->orderByDesc('id')
            ->limit(20)->pluck('group_id')->toArray();
    }

    ##############################    get users count    ##################################
    public  function getSpecific($slug):Groups
    {
        return Groups::where('slug',$slug)->first();
    }
}
