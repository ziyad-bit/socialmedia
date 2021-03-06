<?php

namespace App\AbstractClasses;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

abstract class Search
{
	//########################################     friends     #############################
	protected function friends(string $search):Builder
	{
		return  User::selection()
			->with(['auth_add_friends' => fn ($q) => $q->authUser(),
				'friends_add_auth'        => fn ($q) => $q->authFriend(), ])
			->whereHas('auth_add_friends', fn ($q) => $q->authUser())
			->orWhereHas('friends_add_auth', fn ($q) => $q->authFriend())
			->search($search, null, true);
	}

	//########################################      users      #############################
	protected function users(string $search):Builder
	{
		return User::selection()
			->whereDoesntHave('auth_add_friends', fn ($q) => $q->authUser())
			->WhereDoesntHave('friends_add_auth', fn ($q) => $q->authFriend())
			->notAuth()->search($search, null, true);
	}

	//########################################     groupsJoined     #############################
	protected function groupsJoined(string $search):Builder
	{
		return Groups::selection()->whereHas('group_users', fn ($q) => $q->authUser())
			->with(['group_users' => fn ($q) => $q->authUser()])->search($search, null, true);
	}

	//########################################     groups     #############################
	protected function groups(string $search):Builder
	{
		return Groups::selection()->whereDoesntHave('group_users', fn ($q) => $q->authUser())
			->search($search, null, true);
	}
}
