<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Group_users;
use App\Models\Roles;
use App\Models\User;
use App\Traits\GetPageCode;

class GroupAdminsController extends Controller
{
    use GetPageCode;
    ###########################################      show        ########################
    public function show(Group_users $group_admin)
    {
        $group_admins = User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['role_id' => Roles::group_admin, 'group_id' => $group_admin->group_id]))
            ->cursorPaginate(2);

        $page_code = $this->getPageCode($group_admins);
        
        $view = view('users.groups.index_admins', compact('group_admins'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ###########################################    remove admin   ########################
    public function update(Group_users $group_admin)
    {
        $this->authorize('owner', [Group_users::class, $group_admin]);

        $group_admin->update(['role_id' => Roles::group_member]);

        return response()->json(['success' => 'you removed this admin successfully']);
    }

    ###########################################    delete    #############################
    public function destroy(Group_users $group_admin)
    {
        $this->authorize('owner', [Group_users::class, $group_admin]);

        $group_admin->delete();

        return response()->json(['success' => 'you deleted admin successfully']);
    }
}
