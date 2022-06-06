<?php

namespace App\Http\Controllers\Users;

use App\Classes\Friends\Friends;
use App\Traits\GetPageCode;
use App\Events\ReceiveReqNotify;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\{JsonResponse,Request};
use App\Models\{Friends_user, Notifications};

class FriendsController extends Controller
{
    use GetPageCode;

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    ##########################################    show_requests    #########################
    public function show_requests(Request $request):View|JsonResponse
    { 
        $friend_reqs = Friends::getRequests();

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
        $auth_user = ['user_id' => Auth::id()];

        $req_data  = $request->validated() + $auth_user;
        $req       = Friends_user::where($req_data)->first();

        if ($req == null) {
            $receiver_id = $request->friend_id;

            Friends_user::create($req_data);
            Notifications::Create(['type'=>'friend_req','receiver_id'=>$receiver_id ] + $auth_user);
            event(new ReceiveReqNotify($receiver_id));
        }else{
            return response()->json(['error'=>__("messages.you can't send request again")]);
        }
        
        return response()->json(['success'=>__('messages.you send it successfully')]);
    }

    ##########################################    approve request   #################################
    public function update(Friends_user $friend):JsonResponse
    {
        $this->authorize('update_or_delete',$friend);
        
        $friend->update(['status'=>Friends_user::friend]);

        Cache::forget('friends_ids_'.Auth::id());

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

        Cache::forget('friends_ids_'.Auth::id());

        return response()->json(['success'=>'you unfriend successfully']);
    }
}
