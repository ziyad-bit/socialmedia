<?php

namespace App\Classes\Search;

use App\AbstractClasses\Search;
use Illuminate\Pagination\Paginator;

class PaginateSearch extends Search
{
    private string $search;
    private int $items_num;

    public function __construct(string $search , int $items_num)
    {
        $this->search    = $search;
        $this->items_num = $items_num;
    }

    #######################################      friends      ##########################
    public function paginateFriends():Paginator
    {
        return $this->friends($this->search)->simplePaginate($this->items_num);
    }

    #######################################      users      ##########################
    public function paginateUsers():Paginator
    {
        return $this->users($this->search)->simplePaginate($this->items_num);
    }

    #######################################      groupsJoined      ##########################
    public function paginateGroupsJoined():Paginator
    {
        return $this->groupsJoined($this->search)->simplePaginate($this->items_num);
    }

    #######################################      groups      ##########################
    public function paginateGroups():Paginator
    {
        return $this->groups($this->search)->simplePaginate($this->items_num);
    }
}
