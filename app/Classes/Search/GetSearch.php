<?php

namespace App\Classes\Search;

use App\AbstractClasses\Search;
use Illuminate\Database\Eloquent\Collection;

class GetSearch extends Search
{
    private string $search;
    private int $items_num;

    public function __construct(string $search , int $items_num)
    {
        $this->search    = $search;
        $this->items_num = $items_num;
    }

    ######################################      friends     ###############################
    public function get_friends():Collection
    {
        return  $this->friends($this->search)->limit($this->items_num)->get();
    }

    ######################################      users      ###############################
    public function getUsers():Collection
    {
        return $this->users($this->search)->limit($this->items_num)->get();
    }

    ######################################      groups joined     ###############################
    public function getGroupsJoined():Collection
    {
        return $this->groupsJoined($this->search)->limit($this->items_num)->get();
    }

    ######################################      groups     ###############################
    public function getGroups():Collection
    {
        return $this->groups($this->search)->limit($this->items_num)->get();
    }
}
