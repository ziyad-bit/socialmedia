<?php

namespace App\Http\Controllers\Users;

use App\Classes\Group\GroupFactory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\{Group_users,Roles};
use App\Traits\{GetPageCode,GetGroupAuth};

class GroupUsersController extends Controller
{
    use GetPageCode , GetGroupAuth;

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    ###########################################    show members   ########################
    public function show(Group_users $group_user):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin_member',$group_auth);

        $groupFactory = GroupFactory::factory('GroupUsers');
        $group_users  = $groupFactory->get($group_user->group_id);

        $page_code  = $this->getPageCode($group_users);

        $view = view('users.groups.index_members', compact('group_users','group_auth'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ###########################################    add admin   ########################
    public function update(Group_users $group_user):JsonResponse
    {
        $group_auth=$this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_user->update(['role_id'=>Roles::group_admin]);

        return response()->json(['success'=>__('messages.you did it successfully')]);
    }

    ###########################################    punish members   ########################
    public function punish(Group_users $group_user):JsonResponse
    {
        $group_auth=$this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_user->update(['punish'=>Group_users::punished]);

        return response()->json(['success'=>__('messages.you did it successfully')]);
    }

    ###########################################    delete members   ########################
    public function destroy(Group_users $group_user):JsonResponse
    {
        $group_auth=$this->getGroupAuth($group_user->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_user->delete();

        return response()->json(['success'=>__('messages.you deleted it successfully')]);
    }
}
