<?php

namespace App\Http\Controllers\Users;

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

    public function __construct()
    {
        $this->middleware(userMiddleware());
    }
    
    ##########################################    show_requests    #########################
    public function show_requests(Request $request):View|JsonResponse
    {
        $friend_reqs = User::selection()->with('friends_add_auth:id')
            ->whereHas('friends_add_auth',fn($q)=>$q->where(['status'=>Friends_user::friend_req,'friend_id'=>Auth::id()]))
            ->orderByDesc('id')->cursorPaginate(5);
        
        $page_code = $this->getPageCode($friend_reqs);
        
        if ($request->ajax()) {
            $view = view('users.friends.next_requests', compact('friend_reqs'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.friends.index', compact('friend_reqs','page_code'));
    }

    ##########################################    store request   ###################################
    public function store(FriendRequest $request):JsonResponse
    {
        Friends_user::firstOrCreate($request->validated()+['user_id' => Auth::id()]);

        return response()->json(['success'=>__('messages.you send it successfully')]);
    }

    ##########################################    approve request   #################################
    public function update(Friends_user $friend):JsonResponse
    {
        $this->authorize('update_or_delete',$friend);
        
        $friend->update(['status'=>Friends_user::friend]);
        return response()->json(['success'=>__('messages.you approve it successfully')]);
    }

    ##########################################    ignore  request   ################################# 
    public function ignore(Friends_user $friend):JsonResponse
    {
        $this->authorize('update_or_delete',$friend);
        
        $friend->update(['status'=>Friends_user::ignored_user]);
        return response()->json(['success'=>__('messages.you ignore it successfully')]);
    }
}
