<?php

namespace App\Interfaces\Posts;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface FetchPosts
{
	public function fetchPosts(int $items_num, array $friends_ids, array $groupJoinedIds = [], int $group_id = null, array $shared_posts_id = [], int $user_id = null):CursorPaginator|Collection;
}
