<?php

namespace App\Classes\Group;

use App\Interfaces\Group\Get;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;

class GroupUsers implements Get
{
	//#############################    get admins   ##################################
	public function get(int $group_id, int $items_num):CursorPaginator
	{
		return User::selection()->with('group_joined:id')
			->whereHas('group_joined', fn ($q) => $q->where(['role_id' => Roles::group_member, 'group_id' => $group_id]))
			->notAuth()->cursorPaginate($items_num);
	}
}
