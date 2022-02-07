<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function show_posts()
    {
        $friends_posts= User::with(['posts'=>fn($q)=>$q->selection()->withCount('comments')
                                                    ->with(['comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])])
            ->whereHas  ('friends_add_auth', fn($q) => $q->friends_add_auth())
            ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
            ->selection()->latest()->limit(4)->get();

        return view('users.posts.index',compact('friends_posts'));
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
