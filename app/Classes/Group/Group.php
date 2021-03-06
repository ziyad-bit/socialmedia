<?php

namespace App\Classes\Group;

use App\Interfaces\Group\Get;
use App\Models\Group_users;
use App\Models\Groups;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Auth;

class Group implements Get
{
	//#############################    get admins   ##################################
	public function get(int $auth_id, int $items_num):CursorPaginator
	{
		return Groups::selection()->whereHas('group_users', fn ($q) => $q->where('user_id', $auth_id))
			->cursorPaginate($items_num);
	}

	//#############################    get  auth    ##################################
	public function getAuth(int $group_id):Group_users|null
	{
		return Group_users::where('group_id', $group_id)->where('user_id', Auth::id())->first();
	}

	//#############################    get users count    ##################################
	public function get_users_count(int $group_id):int
	{
		return Group_users::where('group_id', $group_id)->where('role_id', '!=', null)->count();
	}

	//#############################    get users count    ##################################
	public function getJoinedIds():array
	{
		return  Group_users::where('user_id', Auth::id())->orderByDesc('id')
			->limit(20)->pluck('group_id')->toArray();
	}

	//#############################    get users count    ##################################
	public function getSpecific($slug):Groups
	{
		return Groups::where('slug', $slug)->first();
	}
}
