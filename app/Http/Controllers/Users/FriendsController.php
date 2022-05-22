<?php

namespace App\Http\Controllers\Users;

use App\Events\ReceiveReqNotify;
use App\Models\{Friends_user, Notifications, User};
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
    public function show_requests(Request $request)//:View|JsonResponse
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
        $auth_user   = ['user_id' => Auth::id()];
        $req         = Friends_user::firstOrCreate($request->validated() + $auth_user);
        $receiver_id = $request->friend_id;

        if ($req) {
            Notifications::create(['type'=>'friend_req','receiver_id'=>$receiver_id ] + $auth_user);
            event(new ReceiveReqNotify($receiver_id));
        }
        
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

    ##########################################     unfriend    ################################# 
    public function destroy(Friends_user $friend):JsonResponse
    {
        $this->authorize('update_or_delete',$friend);
        
        $friend->delete();
        return response()->json(['success'=>'you unfriend successfully']);
    }
}
