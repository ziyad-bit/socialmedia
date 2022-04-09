<?php

namespace App\Classes\Search;

use App\AbstractClasses\Search;
use Illuminate\Database\Eloquent\Collection;

class GetSearch extends Search
{
    public string $search;
    public int $items_num;

    public function __construct(string $search , int $items_num)
    {
        $this->search    = $search;
        $this->items_num = $items_num;
    }

    ######################################      friends     ###############################
    public function get_friends():Collection
    {
        return $this->friends($this->search)->limit(3)->get();
    }

    ######################################      users      ###############################
    public function getUsers():Collection
    {
        return $this->users($this->search)->limit(2)->get();
    }

    ######################################      groups joined     ###############################
    public function getGroupsJoined():Collection
    {
        return $this->groupsJoined($this->search)->limit(3)->get();
    }

    ######################################      groups     ###############################
    public function getGroups():Collection
    {
        return $this->groups($this->search)->limit(2)->get();
    }
}
