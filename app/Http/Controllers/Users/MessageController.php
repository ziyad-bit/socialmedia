<?php

namespace App\Http\Controllers\Users;

use App\Classes\Friends\Friends;
use App\Events\MessageSend;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Messages;
use App\Models\User;
use App\Traits\GetFriends;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{Request,JsonResponse};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    use GetFriends;

    public function __construct()
    {
        $this->middleware(userMiddleware());
    }

    #############################     index_friends     #######################################
    public function index_friends(Request $request):View|JsonResponse
    {
        $friends      = new Friends();
        $auth_friends = $friends->getFriendsByOnlineOrder(5);

        if ($request->ajax()) {
            return response()->json(['auth_friends' => $auth_friends]);
        }

        return view('users.chat.index', compact('auth_friends'));
    }

    #############################     store     #######################################
    public function store(MessageRequest $request):JsonResponse
    {
        $data=$request->validated()+['sender_id'=>Auth::id()];
        Messages::create($data);

        event(new MessageSend($data , Auth::user()));

        return response()->json();
    }

    #############################     show     #######################################
    public function show(int $id):JsonResponse
    {
        $messages_user = Messages::with(['users' => fn ($q)=> $q->selection()])
            ->where  (fn ($q)=> $q->auth_receiver()->where('sender_id', $id))
            ->orWhere(fn ($q)=> $q->Where('receiver_id', $id)->auth_sender())
            ->orderBydesc('id')->limit(6)->get();

        if (count($messages_user) == 0) {
            return response()->json(['error' => 'no messages'], 404);
        }

        return response()->json(['messages' => $messages_user]);
    }

    #############################     update     #######################################
    public function update(Request $request,int $receiver_id):JsonResponse
    {
        $first_msg_id=$request->first_msg_id;

        $messages_user = Messages::with(['users' => fn ($q)=> $q->selection()])
            ->where  (fn($q)=>$q->auth_receiver()->where('sender_id', $receiver_id)->where('id', '<', $first_msg_id))
            ->orWhere(fn($q)=>$q->Where('receiver_id', $receiver_id)->auth_sender()->where('id', '<', $first_msg_id))
            ->orderBydesc('id')->limit(3)->get();

        if (count($messages_user) == 0) {
            return response()->json(['error' => 'messages not found'], 404);
        }

        return response()->json(['messages' => $messages_user]);
    }
}
