<?php

namespace App\Classes\Posts;

use App\Interfaces\Posts\FetchPosts;
use App\Traits\GetPosts;
use Illuminate\Database\Eloquent\Builder;

class PostsPage implements FetchPosts
{
    use GetPosts;

    public function fetchPosts(array $friends_ids,int $group_id=null,array $shared_posts_id=null):Builder
    {
        return $this->getPosts($friends_ids)->whereIn('user_id',$friends_ids)
            ->orWhereIn('id',$shared_posts_id)->orderBydesc('id');
    }
}
