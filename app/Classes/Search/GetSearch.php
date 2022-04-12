<?php

namespace App\Classes\Search;

use App\AbstractClasses\Search;
use Illuminate\Support\Facades\{Cache,Auth};
use Illuminate\Database\Eloquent\Collection;

class GetSearch extends Search
{
    private string $search;
    private int $items_num;
    private int $auth_id;

    public function __construct(string $search , int $items_num)
    {
        $this->search    = $search;
        $this->items_num = $items_num;
        $this->auth_id   = Auth::id();
    }

    ######################################      friends     ###############################
    public function get_friends():Collection
    {
        if (Cache::has('friends'.$this->search.$this->auth_id)) {
            return Cache::get('friends'.$this->search.$this->auth_id);
        }
        
        $friends= $this->friends($this->search)->limit($this->items_num)->get();
        Cache::put('friends'.$this->search.$this->auth_id ,$friends, now()->addMinutes(120));

        return $friends;
    }

    ######################################      users      ###############################
    public function getUsers():Collection
    {
        if (Cache::has('users'.$this->search.$this->auth_id)) {
            return Cache::get('users'.$this->search.$this->auth_id);
        }

        $users=$this->users($this->search)->limit($this->items_num)->get();
        Cache::put('users'.$this->search.$this->auth_id ,$users, now()->addMinutes(120));

        return $users;
    }

    ######################################      groups joined     ###############################
    public function getGroupsJoined():Collection
    {
        if (Cache::has('groups_joined'.$this->search.$this->auth_id)) {
            return Cache::get('groups_joined'.$this->search.$this->auth_id);
        }

        $groups_joined=$this->groupsJoined($this->search)->limit($this->items_num)->get();
        Cache::put('groups_joined'.$this->search.$this->auth_id ,$groups_joined, now()->addMinutes(120));

        return $groups_joined;
    }

    ######################################      groups     ###############################
    public function getGroups():Collection
    {
        if (Cache::has('groups'.$this->search.$this->auth_id)) {
            return Cache::get('groups'.$this->search.$this->auth_id);
        }

        $groups= $this->groups($this->search)->limit($this->items_num)->get();
        Cache::put('groups'.$this->search.$this->auth_id,$groups, now()->addMinutes(120));

        return $groups;
    }
}
