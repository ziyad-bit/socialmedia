<?php

namespace App\Interfaces\Posts;

use Illuminate\Database\Eloquent\Builder;

interface FetchPosts
{
    public function fetchPosts(array $friends_ids,int $group_id=null,array $shared_posts_id=null):Builder;
}
