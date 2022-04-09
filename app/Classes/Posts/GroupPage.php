<?php

namespace App\Classes\Posts;

use App\Interfaces\Posts\FetchPosts;
use App\Traits\GetPosts;
use Illuminate\Database\Eloquent\Builder;

class GroupPage implements FetchPosts
{
    use GetPosts;

    public function fetchPosts(array $friends_ids,int $group_id=null,array $shared_posts_id=null):Builder
    {
        return $this->getPosts($friends_ids)->where('group_id', $group_id)->orderBydesc('id');
    }
}
