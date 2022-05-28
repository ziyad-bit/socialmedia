<?php

namespace App\Http\Controllers\Users;

use App\Classes\Group\GroupFactory;
use App\Events\UpdateGroupOwner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GroupUsersRequest;
use App\Models\{Roles,Group_users};
use App\Traits\{GetGroupAuth,GetPageCode};
use Illuminate\Http\{RedirectResponse,JsonResponse};

class GroupReqsController extends Controller
{
    use GetPageCode ,GetGroupAuth;

    public function __construct()
    {
        $this->middleware(userMiddleware());
    }
    
    ##################################     join    ########################################
    public function store(GroupUsersRequest $request):JsonResponse
    {
        Group_users::firstOrCreate($request->validated() + ['user_id' => Auth::id()]);

        return response()->json(['success' => __('messages.you send it successfully')]);
    }

    ##################################      show      ########################################
    public function show(Group_users $group_req):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_req->group_id);
        $this->authorize('owner_admin', $group_auth);

        $group_factory = GroupFactory::factory('GroupReq');
        $group_reqs    = $group_factory->get($group_req->group_id);

        $page_code = $this->getPageCode($group_reqs);
        
        $view = view('users.groups.index_requests', compact('group_reqs'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

    ##################################     approve     ########################################
    public function update(Group_users $group_req):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_req->group_id);
        $this->authorize('owner_admin',$group_auth);
        
        $group_req->update(['role_id'=>Roles::group_member,'status'=>Group_users::approved_req]);

        return response()->json(['success'=>__('messages.you approve it successfully')]);
    }

    ##################################     ignore    ########################################
    public function ignore(Group_users $group_req):JsonResponse
    {
        $group_auth = $this->getGroupAuth($group_req->group_id);
        $this->authorize('owner_admin',$group_auth);

        $group_req->update(['status'=>Group_users::ignored_req]);

        return response()->json(['success'=>__('messages.you ignore it successfully')]);
    }

    ##################################     leave     ########################################
    public function destroy(Group_users $group_req):RedirectResponse
    {
        $group_auth = $this->getGroupAuth($group_req->group_id);
        $this->authorize('owner_admin_member',$group_auth);

        $groupFactory = GroupFactory::factory('GroupAdmin');
        $group_admin  = $groupFactory->getAdmin($group_req->group_id);

        if ($group_req->role_id == Roles::group_owner) {
            if ($group_admin) {
                event(new UpdateGroupOwner($group_admin));
            } else {
                return redirect()->back()->with('error', 'you should add admin before leaving');
            }
        }

        $group_req->delete();

        return redirect()->back()->with('success', __('messages.you left it successfully'));
    }
}
