<?php

namespace App\Classes\Group;

use App\Interfaces\Group\Get;
use App\Models\User;
use App\Models\Roles;
use App\Models\Group_users;
use Illuminate\Pagination\CursorPaginator;

class GroupAdmin implements Get
{
    ##############################    get admins   ##################################
    public function get(int $group_id):CursorPaginator
    {
        return User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['role_id' => Roles::group_admin, 'group_id' => $group_id]))
            ->cursorPaginate(2);
    }

    ##############################    get admin   ##################################
    public function getAdmin(int $group_id)
    {
        return Group_users::where('group_id',$group_id)->where('role_id',Roles::group_admin)->first();
    }
}
