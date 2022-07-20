<?php

namespace App\Classes\Search;

use App\AbstractClasses\Search;
use Illuminate\Database\Eloquent\Collection;

class GetSearch extends Search
{
	//#####################################      friends     ###############################
	public function get_friends($search, $items_num):Collection
	{
		return  $this->friends($search)->limit($items_num)->get();
	}

	//#####################################      users      ###############################
	public function getUsers($search, $items_num):Collection
	{
		return $this->users($search)->limit($items_num)->get();
	}

	//#####################################      groups joined     ###############################
	public function getGroupsJoined($search, $items_num):Collection
	{
		return $this->groupsJoined($search)->limit($items_num)->get();
	}

	//#####################################      groups     ###############################
	public function getGroups($search, $items_num):Collection
	{
		return $this->groups($search)->limit($items_num)->get();
	}
}
