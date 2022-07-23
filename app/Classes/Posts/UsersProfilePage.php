<?php

namespace App\Classes\Posts;

use App\Interfaces\Posts\FetchPosts;
use App\Traits\GetPosts;
use Illuminate\Database\Eloquent\Collection;
use  Illuminate\Contracts\Pagination\CursorPaginator;

class UsersProfilePage implements FetchPosts
{
	use GetPosts;

	public function fetchPosts(int $items_num, array $friends_ids, array $groupJoinedIds = [], int $group_id = null, array $shared_posts_id = [], int $user_id = null):CursorPaginator|Collection
	{
		return $this->getPosts($friends_ids)->where('user_id', $user_id)->orderBydesc('id')->cursorPaginate($items_num);
	}
}
