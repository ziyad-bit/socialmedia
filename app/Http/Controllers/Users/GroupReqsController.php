<?php

namespace App\Http\Controllers\Users;

use App\Traits\GetPageCode;
use App\Classes\{GetGroupAdmin,GetGroupAuth};
use App\Events\UpdateGroupOwner;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GroupUsersRequest;
use App\Models\{User,Roles,Group_users , Groups};

class GroupReqsController extends Controller
{
    use GetPageCode;

    ##################################     join    ########################################
    public function store(GroupUsersRequest $request):JsonResponse
    {
        $group = Groups::findOrFail($request->group_id);
        $this->authorize('store_requests', $group);

        Group_users::create($request->validated() + ['user_id' => Auth::id()]);

        return response()->json(['success' => 'you sent request successfully']);
    }

    ##################################      show      ########################################
    public function show(Group_users $group_req):JsonResponse
    {
        $this->authorize('owner_admin', [Group_users::class,$group_req]);

        $group_reqs = User::selection()->with('group_joined:id')
            ->whereHas('group_joined', fn($q) => $q->where(['group_id' => $group_req->group_id ,'group_users.status' => Group_users::join_req] ))
            ->cursorPaginate(3);

        $page_code = $this->getPageCode($group_reqs);

        $view = view('users.groups.index_requests', compact('group_reqs'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ##################################     approve     ########################################
    public function update( Group_users $group_req):JsonResponse
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_req);
        $this->authorize('owner_admin',[Group_users::class,$group_auth]);

        $group_req->update(['role_id'=>Roles::group_member,'status'=>Group_users::approved_req]);

        return response()->json(['success'=>'you approved request successfully']);
    }

    ##################################     ignore    ########################################
    public function ignore( Group_users $group_req):JsonResponse
    {
        $group_auth=GetGroupAuth::getGroupAuth($group_req);
        $this->authorize('owner_admin',[Group_users::class,$group_auth]);

        $group_req->update(['status'=>Group_users::ignored_req]);

        return response()->json(['success'=>'you ignored request successfully']);
    }

    ##################################     leave     ########################################
    public function destroy(Group_users $group_req):RedirectResponse
    {
        $this->authorize('owner_admin_member',[Group_users::class,$group_req]);

        $group_admin = GetGroupAdmin::getGroupAdmin($group_req);
        if ($group_req->role_id == Roles::group_owner) {
            if ($group_admin) {
                event(new UpdateGroupOwner($group_admin));
            } else {
                return redirect()->back()->with('error', 'you should add admin before leaving');
            }
        }

        $group_req->delete();

        return redirect()->back()->with('success', 'you left group successfully');
    }
}
