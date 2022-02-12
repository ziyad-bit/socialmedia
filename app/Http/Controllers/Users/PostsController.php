<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Shares;
use App\Models\User;
use App\Traits\Friends_ids;
use App\Traits\Shared_posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    use Friends_ids , Shared_posts;

    public function index_posts(Request $request)
    {
        $friends_ids=$this->getFriendsIds();
        
        $shared_posts=$this->getSharedPosts($friends_ids);
        
        $friends_posts=Posts::withCount(['comments','likes','shares'])
                    ->with(['users'=>fn($q)=>$q->selection() ,'likes'=>fn($q)=>$q->where('user_id',Auth::id()),
                        'shares'=>fn($q)=>$q->where('user_id',Auth::id()),
                        'comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])
                        ->whereIn('user_id',$friends_ids)->latest()->limit(2)->paginate(2)
                        ->map(function($post){
                            $post->comments=$post->comments->take(4);
                            return $post;
                        });

        if ($request->has('agax')) {
            $view=view('users.posts.index_posts',compact('friends_posts','shared_posts'))->render();
            return response()->json(['view'=>$view]);
        }

        return view('users.posts.index',compact('friends_posts','shared_posts'));
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
