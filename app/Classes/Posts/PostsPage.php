<?php

namespace App\Classes\Posts;

use App\Interfaces\Posts\FetchPosts;
use App\Traits\GetPosts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;

class PostsPage implements FetchPosts
{
    use GetPosts;

    public function fetchPosts(int $items_num,array $friends_ids,int $group_id=null,array $shared_posts_id=null,int $user_id=null):CursorPaginator|Collection
    {
        return $this->getPosts($friends_ids)->whereIn('user_id',$friends_ids)
            ->orWhereIn('id',$shared_posts_id)->orderBydesc('id')->simplePaginate($items_num)
            ->map(function($posts){
                $posts->shares=$posts->shares->take(3);
                return $posts;
            });
    }
}
