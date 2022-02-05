<?php

namespace App\Http\Controllers\Users;

use App\Events\MessageSend;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\{User,Messages};
use Illuminate\Contracts\View\View;
use Illuminate\Http\{Request,JsonResponse};
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
#############################     index_friends     #######################################
    public function index_friends(Request $request):View|JsonResponse
    {
        $friends_user = User::whereHas  ('friends_add_auth', fn($q) => $q->friends_add_auth())
                            ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
                            ->selection()->paginate(4);

        if ($request->has('agax')) {
            return response()->json(['friends_user' => $friends_user]);
        }

        return view('users.chat.index', compact('friends_user'));
    }

    #############################     store     #######################################
    public function store(MessageRequest $request):JsonResponse
    {
        $data=$request->validated()+['sender_id'=>Auth::id()];
        Messages::create($data);

        event(new MessageSend($data , Auth::user()->name));

        return response()->json();
    }

    #############################     show     #######################################
    public function show(int $id):JsonResponse
    {
        $messages_user = Messages::with(['users' => fn ($q)=> $q->selection()])
            ->where  (fn ($q)=> $q->auth_receiver()->where('sender_id', $id))
            ->orWhere(fn ($q)=> $q->Where('receiver_id', $id)->auth_sender())
            ->latest()->limit(6)->get();

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
            ->latest()->limit(3)->get();

        if (count($messages_user) == 0) {
            return response()->json(['error' => 'messages not found'], 404);
        }

        return response()->json(['messages' => $messages_user]);
    }
}
