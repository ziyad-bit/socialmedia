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

 
    public function show($id)
    {
        //
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
