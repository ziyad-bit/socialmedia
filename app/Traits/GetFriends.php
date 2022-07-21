<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait GetFriends
{
	public function getFriends(int $user_id):Builder
	{
		return User::selection()->whereHas('friends_add_auth', fn ($q) => $q->where(['status' => 1, 'friend_id' => $user_id]))
			->orWhereHas('auth_add_friends', fn ($q) => $q->where(['status' => 1, 'user_id' => $user_id]));
	}
}
