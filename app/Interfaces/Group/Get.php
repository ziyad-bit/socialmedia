<?php

namespace App\Interfaces\Group;

use  Illuminate\Contracts\Pagination\CursorPaginator;

interface Get
{
	public function get(int $group_id, int $items_num):CursorPaginator;
}
