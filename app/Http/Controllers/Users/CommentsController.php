<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\{Posts,Comments};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(userMiddleware());
        $this->middleware(['throttle:1,10'])->only(['store']);
    }
    
    #############################     store    #######################################
    public function store(CommentRequest $request):JsonResponse
    {
        $comment = Comments::create($request->validated() + ['user_id' => Auth::id()]);

        $view = view('users.posts.add_comments', compact('comment'))->render();
        return response()->json(['view' => $view]);
    }

    #############################     show     #######################################
    public function show(int $post_id):JsonResponse
    {
        $comments = Posts::findOrFail($post_id)->comments;

        $view = view('users.posts.index_comments', compact('comments'))->render();
        return response()->json(['view' => $view]);
    }

    #############################     show_more     #######################################
    public function show_more(int $com_id, int $post_id):JsonResponse
    {
        $comments = Comments::selection()->with(['user' => fn($q) => $q->selection()])->where('post_id', $post_id)
            ->where('id', '<', $com_id)->orderByDesc('id')->limit(5)->get();

        if ($comments->count() == 0) {
            return response()->json([], 404);
        }

        $view = view('users.posts.index_comments', compact('comments'))->render();
        return response()->json(['view' => $view]);
    }

    #############################     update     #######################################
    public function update(CommentRequest $request, Comments $comment):JsonResponse
    {
        $this->authorize('update_or_delete', $comment);
        $comment->update($request->except('post_id'));

        return response()->json(['success_msg' => __('messages.you updated it successfully')]);
    }

    #############################     destroy     #######################################
    public function destroy(Comments $comment):JsonResponse
    {
        $this->authorize('update_or_delete', $comment);
        $comment->delete();

        return response()->json(['success_msg' => __('messages.you deleted it successfully')]);
    }
}
