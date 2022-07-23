<?php

namespace App\Classes\Group;

use App\Models\Group_users;
use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;

class GroupReq
{
	//#############################    get reqs   ##################################
	public function get(int $group_id, int $items_num):CursorPaginator
	{
		return User::selection()->with('group_joined:id')
			->whereHas('group_joined', fn ($q) => $q->where(['group_id' => $group_id, 'group_users.status' => Group_users::join_req]))
			->cursorPaginate($items_num);
	}
}
