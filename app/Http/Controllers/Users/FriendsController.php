<?php

namespace App\Http\Controllers\Users;

use App\Classes\GetFriendReq;
use App\Models\{Friends_user,User};
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequest;
use App\Traits\GetPageCode;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    use GetPageCode;
    ##########################################    show_requests    #########################
    public function show_requests(Request $request):View|JsonResponse
    {
        $friend_reqs = User::with('friends_add_auth:id')
            ->whereHas('friends_add_auth',fn($q)=>$q->where(['status'=>Friends_user::friend_req,'friend_id'=>Auth::id()]))
            ->selection()->orderByDesc('id')->cursorPaginate(4);
        
        $page_code = $this->getPageCode($friend_reqs);
        
        if ($request->has('agax')) {
            $view = view('users.friends.next_requests', compact('friend_reqs'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.friends.index', compact('friend_reqs','page_code'));
    }

    ##########################################    store    ###################################
    public function store(FriendRequest $request)//:JsonResponse
    {
        $friend_id = $request->friend_id;

        $friend_req=GetFriendReq::get($friend_id);
        if ($friend_req) {
            return response()->json([],422);
        }

        Friends_user::create(['friend_id'=>$friend_id,'user_id' => Auth::id()]);

        return response()->json();
    }

    ##########################################    update    #################################
    public function update(Friends_user $friend):JsonResponse
    {
        $this->authorize('update_or_delete',$friend);
        
        $friend->update(['status'=>Friends_user::friend]);
        return response()->json();
    }

    ##########################################    show    #################################
    //ignore friends request
    public function show(Friends_user $friend):JsonResponse
    {
        $this->authorize('update_or_delete',$friend);
        
        $friend->update(['status'=>Friends_user::ignored_user]);
        return response()->json();
    }
}
