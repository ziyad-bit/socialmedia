<?php

namespace App\Http\Controllers\Users;

use App\Classes\Friends\Friends;
use App\Classes\Messages\Msgs;
use App\Classes\Search\PaginateSearchFactory;
use App\Events\MessageSend;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Messages;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	//############################     index_friends     #######################################
	public function index_friends(Request $request, Friends $friends):View|JsonResponse
	{
		try {
			$auth_friends=$friends->getByOnlineOrder(5);
			$friends_ids=$friends->fetchIds(Auth::id());

			$friends_msgs=Msgs::getLast($friends_ids)->simplePaginate(6);

			if ($request->ajax()) {
				return response()->json(['auth_friends'=>$auth_friends]);
			}

			return view('users.chat.index', compact('auth_friends', 'friends_msgs'));
		} catch (\Exception) {
			return redirect()->route('posts.index.all')->with('error', 'something went wrong');
		}
	}

	//############################     store     #######################################
	public function store(MessageRequest $request):JsonResponse
	{
		try {
			Messages::getMsgs($request->receiver_id)->where('last', 1)->update(['last'=>0]);

			event(new MessageSend($request->validated(), Auth::user()));

			Messages::create($request->validated()+['sender_id'=>Auth::id()]);

			return response()->json();
		} catch (\Exception) {
			return response()->json(['error'=>'something went wrong'], 500);
		}
	}

	//############################        show       #######################################
	public function show(int $id):JsonResponse
	{
		try {
			$messages_user=Msgs::get($id);

			if (count($messages_user)==0) {
				return response()->json(['error'=>'no messages'], 404);
			}

			$view=view('users.chat.index_msgs', compact('messages_user'))->render();

			return response()->json(['view'=>$view]);
		} catch (\Exception) {
			return response()->json(['error'=>'something went wrong'], 500);
		}
	}

	//############################     update to load old msgs    #######################################
	public function update(Request $request, int $id):JsonResponse
	{
		try {
			$messages_user=Msgs::get_more($id, $request->first_msg_id);

			if (count($messages_user)==0) {
				return response()->json(['error'=>'messages not found'], 404);
			}

			$view=view('users.chat.index_msgs', compact('messages_user'))->render();

			return response()->json(['view'=>$view]);
		} catch (\Exception) {
			return response()->json(['error'=>'something went wrong'], 500);
		}
	}

	//############################     search friends     #######################################
	public function search_friends(SearchRequest $request, PaginateSearchFactory $search_factory):JsonResponse
	{
		try {
			$search=$request->search;

			//factory method design pattern
			$friends=$search_factory->createSearch()->paginateFriends($search, 7);

			$friends_view=view('users.chat.index_friends', compact('friends', 'search'))->render();
			$friends_tab_view=view('users.chat.index_friends_tab', compact('friends', 'search'))->render();

			return response()->json([
				'friends_view'=>$friends_view,
				'friends_tab_view'=>$friends_tab_view,
			]);
		} catch (\Exception) {
			return response()->json(['error'=>'something went wrong'], 500);
		}
	}

	//############################     search last msgs     #######################################
	public function search_last_msgs(SearchRequest $request, Friends $friends):JsonResponse
	{
		try {
			$search=$request->search;

			$friends_ids=$friends->fetchIds(Auth::id());

			$friends_msgs=Msgs::getLast($friends_ids)->search($search)->simplePaginate(6);

			$last_msgs_view=view('users.chat.index_last_msgs', compact('friends_msgs', 'search'))->render();
			$last_msgs_tab_view=view('users.chat.index_last_msgs_tab', compact('friends_msgs', 'search'))->render();

			return response()->json([
				'last_msgs_view'=>$last_msgs_view,
				'last_msgs_tab_view'=>$last_msgs_tab_view,
			]);
		} catch (\Exception) {
			return response()->json(['error'=>'something went wrong'], 500);
		}
	}
}
