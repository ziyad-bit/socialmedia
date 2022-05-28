<?php

namespace App\Http\Controllers\Users;

use App\Models\Messages;
use App\Events\MessageSend;
use App\Classes\Friends\Friends;
use App\Classes\Messages\Msgs;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;
use Illuminate\Http\{Request,JsonResponse};
use App\Classes\Search\PaginateSearchFactory;
use Illuminate\Support\Facades\Crypt;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(userMiddleware());
    }

    #############################     index_friends     #######################################
    public function index_friends(Request $request):View|JsonResponse
    {
        $friends      = new Friends();
        $auth_friends = $friends->getByOnlineOrder(5);
        $friends_ids  = $friends->fetchIds(Auth::id());

        $friends_msgs = Msgs::getLast($friends_ids)->simplePaginate(6);
            
        if ($request->ajax()) {
            return response()->json(['auth_friends' => $auth_friends]);
        }

        return view('users.chat.index', compact('auth_friends','friends_msgs'));
    }

    #############################     store     #######################################
    public function store(MessageRequest $request):JsonResponse
    {
        $sender_id =['sender_id'=>Auth::id()];

        Messages::getMsgs($request->receiver_id)->where('last',1)->update(['last'=>0]);

        event(new MessageSend($request->validated()+$sender_id , Auth::user()));

        $encrypted_text=Crypt::encrypt($request->text);
        Messages::create($request->except('text')+$sender_id+['text'=>$encrypted_text]);

        return response()->json();
    }

    #############################        show       #######################################
    public function show(int $id):JsonResponse
    {
        $messages_user = Msgs::get($id);

        if (count($messages_user) == 0) {
            return response()->json(['error' => 'no messages'], 404);
        }

        $view=view('users.chat.index_msgs',compact('messages_user'))->render();

        return response()->json(['view' => $view]);
    }

    #############################     update to load old msgs    #######################################
    public function update(Request $request,int $id):JsonResponse
    {
        $messages_user = Msgs::get_more($id,$request->first_msg_id);

        if (count($messages_user) == 0) {
            return response()->json(['error' => 'messages not found'], 404);
        }

        $view=view('users.chat.index_msgs',compact('messages_user'))->render();

        return response()->json(['view' => $view]);
    }

    #############################     search_friends     #######################################
    public function search_friends(SearchRequest $request):JsonResponse
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
    public function search_last_msgs(SearchRequest $request):JsonResponse
    {
        $search = $request->search;

        $friends_ins = new Friends();
        $friends_ids = $friends_ins->fetchIds(Auth::id());

        $friends_msgs = Msgs::getLast($friends_ids)->search($search)->simplePaginate(6);

        $last_msgs_view     = view('users.chat.index_last_msgs',compact('friends_msgs','search'))->render();
        $last_msgs_tab_view = view('users.chat.index_last_msgs_tab',compact('friends_msgs','search'))->render();

        return response()->json([
                'last_msgs_view'     => $last_msgs_view,
                'last_msgs_tab_view' => $last_msgs_tab_view,
            ]);
    }
}
