<?php

namespace App\Classes\Group;

use App\Interfaces\Group\Get;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Pagination\CursorPaginator;

class GroupUsers implements Get
{
    ##############################    get admins   ##################################
    public function get(int $group_id):CursorPaginator
    {
        return User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['role_id'=>Roles::group_member,'group_id'=>$group_id]))
            ->cursorPaginate(2);
    }
}
