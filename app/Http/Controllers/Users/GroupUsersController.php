<?php

namespace App\Http\Controllers\Users;

use App\Classes\GroupReq;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupUsersRequest;
use App\Models\Group_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupUsersController extends Controller
{
    
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
        $group_id  = $request->group_id;
        $group_req = GroupReq::get($group_id);

        if ($group_req) {
            return response()->json([],400);
        }

        Group_users::create(['group_id'=>$group_id,'user_id'=>Auth::id()]);

        return response()->json(['success'=>'you send request successfully']);
    }

   
    public function show(Group_users $group_users)
    {
        //
    }

  
    public function edit(Group_users $group_users)
    {
        //
    }

   
    public function update(Request $request, Group_users $group_users)
    {
        //
    }

  
    public function destroy(Group_users $group_users)
    {
        //
    }
}
