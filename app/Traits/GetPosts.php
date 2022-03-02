<?php

namespace App\Traits;

use App\Models\Posts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait GetPosts
{
    public function getPosts(array $friends_ids):Builder
    {
        return Posts::selection()->withCount(['comments','likes','shares'])
            ->with(['users'=>fn($q)=>$q->selection() ,'likes'=>fn($q)=>$q->where('user_id',Auth::id()),
            'shares'=>fn($q)=>$q->whereIn('user_id',$friends_ids)->with(['users'=>fn($q)=>$q->selection()])]);
    }
}
