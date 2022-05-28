<?php

namespace App\Interfaces\Group;

use Illuminate\Pagination\CursorPaginator;

interface Get
{
    public function get(int $group_id):CursorPaginator;
}
