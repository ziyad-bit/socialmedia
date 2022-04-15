<?php

namespace App\Interfaces\Posts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;

interface FetchPosts
{
    public function fetchPosts(int $items_num,array $friends_ids,int $group_id=null,array $shared_posts_id=null,int $user_id=null):CursorPaginator|Collection;
}
