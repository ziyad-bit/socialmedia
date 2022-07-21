<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use App\Models\Posts;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
		$this->middleware(['throttle:10,1'])->only(['store']);
	}

	//############################     store    #######################################
	public function store(CommentRequest $request): JsonResponse
	{
		try {
			$comment = Comments::create($request->validated() + ['user_id' => Auth::id()]);

			$view = view('users.posts.add_comments', compact('comment'))->render();

			return response()->json(['view' => $view]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//############################     show     #######################################
	public function show(int $post_id): JsonResponse
	{
		try {
			$comments = Posts::findOrFail($post_id)->comments;

			$view = view('users.posts.index_comments', compact('comments'))->render();

			return response()->json(['view' => $view]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//############################     show_more     #######################################
	public function show_more(int $com_id, int $post_id): JsonResponse
	{
		try {
			$comments = Comments::selection()->with(['user' => fn ($q) => $q->selection()])->where('post_id', $post_id)
				->where('id', '<', $com_id)->orderByDesc('id')->limit(5)->get();

			if ($comments->count() == 0) {
				return response()->json([], 404);
			}

			$view = view('users.posts.index_comments', compact('comments'))->render();

			return response()->json(['view' => $view]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//############################     update     #######################################
	public function update(CommentRequest $request, Comments $comment): JsonResponse
	{
		try {
			$this->authorize('update_or_delete', $comment);
			$comment->update($request->except('post_id'));

			return response()->json(['success_msg' => __('messages.you updated it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//############################     destroy     #######################################
	public function destroy(Comments $comment): JsonResponse
	{
		try {
			$this->authorize('update_or_delete', $comment);
			$comment->delete();

			return response()->json(['success_msg' => __('messages.you deleted it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}
}
