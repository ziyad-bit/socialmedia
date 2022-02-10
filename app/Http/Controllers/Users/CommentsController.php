<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
   
    public function index()
    {
        //
    }

    
    public function store(CommentRequest $request)
    {
        if ($request->post_id) {
            $comment=Comments::create($request->validated()+['user_id'=>Auth::id()]);
        }else{
            return  response()->json([],500);
        }
        
        $view=view('users.posts.post_comments',compact('comment'))->render();
        return response()->json(['view'=>$view]);
    }

 
    public function show_more(int $com_id,int $post_id)
    {
        $comments=Comments::with(['users'=>fn($q)=>$q->selection()])->selection()->where('post_id',$post_id)
            ->where('id','<',$com_id)->orderByDesc('id')->limit(5)->get();

        if ($comments->count() == 0) {
            return response()->json([],404);
        }

        $view=view('users.posts.index_comments',compact('comments'))->render();
        return response()->json(['view'=>$view]);
    }

   
    public function update(CommentRequest $request,Comments $comment)
    {
        $this->authorize('update_or_delete',$comment);
        $comment->update($request->validated());

        return response()->json(['success_msg'=>'you updated it successfully']);
    }

   
    public function destroy(Comments $comment)
    {
        $this->authorize('update_or_delete',$comment);
        $comment->delete();

        return response()->json(['success_msg'=>'you deleted it successfully']);
    }
}
