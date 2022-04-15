<?php

namespace App\Classes\Posts;

use App\Traits\GetPosts;
use App\Interfaces\Posts\FetchPosts;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class GroupPage implements FetchPosts
{
    use GetPosts;

    public function fetchPosts(int $items_num,array $friends_ids,int $group_id=null,array $shared_posts_id=null,int $user_id=null):CursorPaginator|Collection
    {
        return $this->getPosts($friends_ids)->where('group_id', $group_id)->orderBydesc('id')->cursorPaginate($items_num);
    }
}
