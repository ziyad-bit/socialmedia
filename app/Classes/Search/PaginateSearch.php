<?php

namespace App\Classes\Search;

use App\AbstractClasses\Search;
use Illuminate\Contracts\Pagination\Paginator;

class PaginateSearch extends Search
{
	//######################################      friends      ##########################
	public function paginateFriends($search, $items_num):Paginator
	{
		return $this->friends($search)->simplePaginate($items_num);
	}

	//######################################      users      ##########################
	public function paginateUsers($search, $items_num):Paginator
	{
		return $this->users($search)->simplePaginate($items_num);
	}

	//######################################      groupsJoined      ##########################
	public function paginateGroupsJoined($search, $items_num):Paginator
	{
		return $this->groupsJoined($search)->simplePaginate($items_num);
	}

	//######################################      groups      ##########################
	public function paginateGroups($search, $items_num):Paginator
	{
		return $this->groups($search)->simplePaginate($items_num);
	}
}
