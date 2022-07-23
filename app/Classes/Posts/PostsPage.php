<?php

namespace App\Classes\Posts;

use App\Interfaces\Posts\FetchPosts;
use App\Traits\GetPosts;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\CursorPaginator;

class PostsPage implements FetchPosts
{
	use GetPosts;

	public function fetchPosts(int $items_num, array $friends_ids, array $groupJoinedIds = [], int $group_id = null, array $shared_posts_id = [], int $user_id = null):CursorPaginator|Collection
	{
		return $this->getPosts($friends_ids)->with(['group' => fn ($q) => $q->whereIn('id', $groupJoinedIds)])
			->whereIn('user_id', $friends_ids)->orWhereIn('id', $shared_posts_id)
			->orWhereIn('group_id', $groupJoinedIds)->orderBydesc('id')->simplePaginate($items_num)
			->map(function ($posts) {
				$posts->shares = $posts->shares->take(3);

				return $posts;
			});
	}
}
