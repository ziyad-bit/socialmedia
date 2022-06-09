<?php

namespace App\Http\Controllers\Users;

use App\Classes\Group\GroupFactory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\{Roles,Group_users};
use App\Traits\{GetAuthInGroup,GetPageCode};

class GroupAdminsController extends Controller
{
    use GetPageCode ,GetAuthInGroup;

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    ###########################################      show        ########################
    public function show(Group_users $group_admin):JsonResponse
    {
        $this->authorize('owner_admin_member',$group_admin);

        $group_auth=$group_admin;

        $group_factory = GroupFactory::factory('GroupAdmin');
        $group_admins  = $group_factory->get($group_admin->group_id);

        $page_code = $this->getPageCode($group_admins);
        
        $view = view('users.groups.index_admins', compact('group_admins','group_auth'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ###########################################    remove admin   ########################
    public function update(Group_users $group_admin):JsonResponse
    {
        $group_auth = $this->getAuthInGroup($group_admin->group_id);
        $this->authorize('owner',  $group_auth);

        $group_admin->update(['role_id' => Roles::group_member]);

        return response()->json(['success' => __('messages.you removed admin successfully')]);
    }

    ###########################################    delete    #############################
    public function destroy(Group_users $group_admin):JsonResponse
    {
        $group_auth = $this->getAuthInGroup($group_admin->group_id);
        $this->authorize('owner',  $group_auth);

        $group_admin->delete();

        return response()->json(['success' => __('messages.you deleted it successfully')]);
    }
}
