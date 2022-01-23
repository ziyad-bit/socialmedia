<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequest;
use App\Models\Friends_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    ##########################################    show_requests    #########################
    public function show_requests(Request $request)
    {
        $friend_reqs = User::with('friends_add:name,photo')
            ->whereHas('friends_add',fn($q)=>$q->where(['status'=>0,'friend_id'=>Auth::id()]))
            ->selection()->cursorPaginate(5);
        
        $page_code='';
        if ($friend_reqs->hasMorePages()) {
            $page_code = $friend_reqs->nextCursor()->encode();
        }

        if ($request->has('agax')) {
            $view = view('users.friends.next_requests', compact('friend_reqs'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.friends.index', compact('friend_reqs','page_code'));
    }

    ##########################################    store    ###################################
    public function store(FriendRequest $request)
    {
        Friends_user::create($request->validated() + ['user_id' => Auth::id()]);

        return response()->json();
    }

    ##########################################    update    #################################
    public function update(Request $request,int $id)
    {
        $friend_req=Friends_user::findOrfail($id);
        $this->authorize('update_or_delete',$friend_req);
        
        $friend_req->update(['status'=>1]);
    }

    ##########################################    show    #################################
    //ignore friends request
    public function show(int $id)
    {
        $friend_req=Friends_user::findOrfail($id);
        $this->authorize('update_or_delete',$friend_req);
        
        $friend_req->update(['status'=>2]);
    }
}
