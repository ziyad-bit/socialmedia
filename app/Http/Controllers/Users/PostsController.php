<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        $friends_ids=User::whereHas('friends_add_auth', fn($q) => $q->friends_add_auth())
                        ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
                        ->pluck('id')->toArray();
        
        $friends_posts=Posts::withCount('comments')->with(['users'=>fn($q)=>$q->selection() ,
                        'comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])
                        ->whereIn('user_id',$friends_ids)->latest()->limit(2)->get();
        
        return view('users.posts.index',compact('friends_posts'));
    }

    public function show(int $id)
    {
        $friends_ids=User::whereHas('friends_add_auth', fn($q) => $q->friends_add_auth())
                        ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
                        ->pluck('id')->toArray();

        $friends_posts=Posts::withCount('comments')->with(['users'=>fn($q)=>$q->selection(),
                    'comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])
                    ->whereIn('user_id',$friends_ids)->where('id','<',$id)
                    ->latest()->limit(2)->get();
        
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
