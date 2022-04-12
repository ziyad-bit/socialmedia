<?php

namespace App\AbstractClasses;

use App\Models\{Groups,User};
use App\Traits\GetFriends;
use Illuminate\Database\Eloquent\Builder;

abstract class Search 
{
    use GetFriends;

    #########################################     friends     #############################
    public function friends(string $search):Builder
    {
        return $this->getFriends()->with(['auth_add_friends:id', 'friends_add_auth:id'])
            ->search($search);
    }

    #########################################      users      #############################
    public function users(string $search):Builder
    {
        return User::selection()
            ->whereDoesntHave('auth_add_friends', fn($q) => $q->auth_add_friends())
            ->orwhereDoesntHave('friends_add_auth', fn($q) => $q->friends_add_auth())
            ->search($search);
    }

    #########################################     groupsJoined     #############################
    public function groupsJoined(string $search):Builder
    {
        return Groups::selection()->whereHas('group_users')
            ->with(['group_users' => fn($q) => $q->authUser()])->search($search);
    }

    #########################################     groups     #############################
    public function groups(string $search):Builder
    {
        return Groups::selection()->whereDoesntHave('group_users', fn($q) => $q->authUser())
            ->search($search);
    }
}
