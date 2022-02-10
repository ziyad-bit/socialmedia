<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\User;
use App\Traits\Friends_ids;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    use Friends_ids;

    public function index()
    {
        $friends_ids=$this->getFriendsIds();
        
        $friends_posts=Posts::withCount('comments')->with(['users'=>fn($q)=>$q->selection() ,
                        'comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])
                        ->whereIn('user_id',$friends_ids)->latest()->limit(2)->get()
                        ->map(function($post){
                            $post->comments=$post->comments->take(4);
                            return $post;
                        });
        
        return view('users.posts.index',compact('friends_posts'));
    }

    public function show(int $id)
    {
        $friends_ids=$this->getFriendsIds();

        $friends_posts=Posts::withCount('comments')
                    ->with(['users'=>fn($q)=>$q->selection()
                    ,'comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])
                    ->whereIn('user_id',$friends_ids)->where('id','<',$id)
                    ->latest()->limit(2)->get()
                    ->map(function($post){
                        $post->comments=$post->comments->take(4);
                        return $post;
                    });
        
        if ($friends_posts->count() == 0) {
            return response()->json([],404);
        }

        $view=view('users.posts.index_posts',compact('friends_posts'))->render();
        return response()->json(['view'=>$view]);
    }

    public function store(Request $request)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
