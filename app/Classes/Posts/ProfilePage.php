<?php

namespace App\Classes\Posts;

use App\Interfaces\Posts\FetchPosts;
use App\Traits\GetPosts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProfilePage implements FetchPosts
{
    use GetPosts;

    public function fetchPosts(array $friends_ids,int $group_id=null,array $shared_posts_id=null):Builder
    {
        return $this->getPosts($friends_ids)->where('user_id',Auth::id())->orderBydesc('id');
    }
}
