<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Groups;
use App\Classes\GroupReq;
use App\Models\Group_users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GroupUsersRequest;
use App\Traits\GetPageCode;

class GroupUsersController extends Controller
{
    use GetPageCode;
    
    public function index()
    {
        //
    }

  
    public function create()
    {
        //
    }

    
    public function store(GroupUsersRequest $request)
    {
        $group=Groups::findOrFail($request->group_id);
        $this->authorize('show',$group);
        
        Group_users::create($request->validated() + ['user_id'=>Auth::id()]);

        return response()->json(['success'=>'you send request successfully']);
    }

   
    public function show(Groups $group)
    {
        $this->authorize('show',$group);

        $group_reqs=User::with('group_joined:id')
                ->whereHas('group_joined',fn($q)=>$q->where(['group_id'=>$group->id,'group_users.status'=>Group_users::join_req]))
                ->selection()->cursorPaginate(3);
            
        $page_code = $this->getPageCode($group_reqs);
            
        $view = view('users.groups.next_requests', compact('group_reqs'))->render();
        return response()->json(['view' => $view, 'page_code' => $page_code]);
    }

  
    public function edit(Group_users $group_req)
    {
        //
    }

   
    public function update(Request $request, Group_users $group_req)
    {
        //
    }

  
    public function destroy(Group_users $group_req)
    {
        //
    }
}
