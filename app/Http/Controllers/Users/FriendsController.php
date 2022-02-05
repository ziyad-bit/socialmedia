<?php

namespace App\Http\Controllers\Users;

use App\Models\{Friends_user,User};
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    ##########################################    show_requests    #########################
    public function show_requests(Request $request):View|JsonResponse
    {
        $friend_reqs = User::with('friends_add_auth:id')
            ->whereHas('friends_add_auth',fn($q)=>$q->where(['status'=>0,'friend_id'=>Auth::id()]))
            ->selection()->orderByDesc('id')->cursorPaginate(4);
        
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
    public function store(FriendRequest $request):JsonResponse
    {
        Friends_user::create($request->validated() + ['user_id' => Auth::id()]);

        return response()->json();
    }

    ##########################################    update    #################################
    public function update(int $id):JsonResponse
    {
        $friend_req=Friends_user::findOrfail($id);
        $this->authorize('update_or_delete',$friend_req);
        
        $friend_req->update(['status'=>1]);
        return response()->json();
    }

    ##########################################    show    #################################
    //ignore friends request
    public function show(int $id):JsonResponse
    {
        $friend_req=Friends_user::findOrfail($id);
        $this->authorize('update_or_delete',$friend_req);
        
        $friend_req->update(['status'=>2]);
        return response()->json();
    }
}
