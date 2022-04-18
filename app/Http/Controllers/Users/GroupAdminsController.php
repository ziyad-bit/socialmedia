<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\{User,Roles,Group_users};
use App\Traits\{GetGroupAuth,GetPageCode};
use Illuminate\Http\JsonResponse;

class GroupAdminsController extends Controller
{
    use GetPageCode ,GetGroupAuth;

    public function __construct()
    {
        $this->middleware(userMiddleware());
    }
    
    ###########################################      show        ########################
    public function show(Group_users $group_admin):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_admin->group_id);
        $this->authorize('owner_admin_member',$group_auth);

        $group_admins = User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['role_id' => Roles::group_admin, 'group_id' => $group_admin->group_id]))
            ->cursorPaginate(2);

        $page_code = $this->getPageCode($group_admins);
        
        $view = view('users.groups.index_admins', compact('group_admins','group_auth'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ###########################################    remove admin   ########################
    public function update(Group_users $group_admin):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_admin->group_id);
        $this->authorize('owner',  $group_auth);

        $group_admin->update(['role_id' => Roles::group_member]);

        return response()->json(['success' => __('messages.you removed admin successfully')]);
    }

    ###########################################    delete    #############################
    public function destroy(Group_users $group_admin):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_admin->group_id);
        $this->authorize('owner',  $group_auth);

        $group_admin->delete();

        return response()->json(['success' => __('messages.you deleted it successfully')]);
    }
}
