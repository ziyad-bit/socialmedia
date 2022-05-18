<?php

namespace App\Http\Controllers\Users;

use App\Models\Messages;
use App\Events\MessageSend;
use App\Classes\Friends\Friends;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\{Request,JsonResponse};
use App\Classes\Search\PaginateSearchFactory;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(userMiddleware());
    }

    #############################     index_friends     #######################################
    public function index_friends(Request $request)//:View|JsonResponse
    {
        $friends      = new Friends();
        $auth_friends = $friends->getByOnlineOrder(5);
        $friends_ids  = $friends->fetchIds(Auth::id());

        $friends_msgs=Messages::selection()->with(['sender','receiver'])
            ->where  (fn ($q)=> $q->auth_receiver()->whereIn('sender_id', $friends_ids)->where('last',1))
            ->orWhere(fn ($q)=> $q->WhereIn('receiver_id', $friends_ids)->auth_sender()->where('last',1))
            ->orderBydesc('id')->simplePaginate(6);
            
        if ($request->ajax()) {
            return response()->json(['auth_friends' => $auth_friends]);
        }

        return view('users.chat.index', compact('auth_friends','friends_msgs'));
    }

    #############################     store     #######################################
    public function store(MessageRequest $request):JsonResponse
    {
        $data = $request->validated() + ['sender_id'=>Auth::id()];

        Messages::where  (fn ($q)=> $q->auth_receiver()->where('sender_id', $request->receiver_id))
                ->orWhere(fn ($q)=> $q->Where('receiver_id', $request->receiver_id)->auth_sender())
                ->where('last',1)->update(['last'=>0]);

        Messages::create($data);

        event(new MessageSend($data , Auth::user()));

        return response()->json();
    }

    #############################     show     #######################################
    public function show(int $id):JsonResponse
    {
        $messages_user = Messages::with(['sender' => fn ($q)=> $q->selection()])
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

        $messages_user = Messages::with(['sender' => fn ($q)=> $q->selection()])
            ->where  (fn($q)=>$q->auth_receiver()->where('sender_id', $receiver_id)->where('id', '<', $first_msg_id))
            ->orWhere(fn($q)=>$q->Where('receiver_id', $receiver_id)->auth_sender()->where('id', '<', $first_msg_id))
            ->orderBydesc('id')->limit(6)->get();

        if (count($messages_user) == 0) {
            return response()->json(['error' => 'messages not found'], 404);
        }

        return response()->json(['messages' => $messages_user]);
    }

    #############################     search_friends     #######################################
    public function search_friends(SearchRequest $request)
    {
        $search = $request->search;

        //factory method design pattern
        $search_factory = new PaginateSearchFactory($search , 7);
        $friends        = $search_factory->createSearch()->paginateFriends();

        $friends_view     = view('users.chat.index_friends',compact('friends','search'))->render();
        $friends_tab_view = view('users.chat.index_friends_tab',compact('friends','search'))->render();

        return response()->json([
                'friends_view'       => $friends_view,
                'friends_tab_view'   => $friends_tab_view,
            ]);
    }

    #############################     search_friends     #######################################
    public function search_last_msgs(SearchRequest $request)
    {
        $search = $request->search;

        $friends_ins = new Friends();
        $friends_ids = $friends_ins->fetchIds(Auth::id());

        $friends_msgs = Messages::selection()->with(['sender','receiver'])
            ->where  (fn ($q) => $q->auth_receiver()->whereIn('sender_id', $friends_ids)->where('last',1))
            ->orWhere(fn ($q) => $q->WhereIn('receiver_id', $friends_ids)->auth_sender()->where('last',1))
            ->orderBydesc('id')->search($search)->simplePaginate(6);

        $last_msgs_view     = view('users.chat.index_last_msgs',compact('friends_msgs','search'))->render();
        $last_msgs_tab_view = view('users.chat.index_last_msgs_tab',compact('friends_msgs','search'))->render();

        return response()->json([
                'last_msgs_view'     => $last_msgs_view,
                'last_msgs_tab_view' => $last_msgs_tab_view,
            ]);
    }
}
