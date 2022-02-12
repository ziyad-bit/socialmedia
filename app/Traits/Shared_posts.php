<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Posts;
use App\Models\Shares;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

trait Shared_posts
{
    public function getSharedPosts(array $friends_ids):Collection
    {
        $shared_posts_id=Shares::whereIn('user_id',$friends_ids)->pluck('post_id')->toArray();
        
        $shared_posts=Posts::withCount(['comments','likes','shares'])
            ->with(['users'=>fn($q)=>$q->selection() ,'likes'=>fn($q)=>$q->where('user_id',Auth::id()),
                    'shares'=>fn($q)=>$q->with(['users'=>fn($q)=>$q->selection()])->whereHas('users'),
                    'comments'=>fn($q)=>$q->selection()->with(['users'=>fn($q)=>$q->selection()])])
                ->whereIn('id',$shared_posts_id)->latest()->limit(2)->paginate(2)
                ->map(function($post){
                    $post->comments=$post->comments->take(4);
                    return $post;
                });
                
        return $shared_posts;
    }
}
