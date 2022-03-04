<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Groups;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupsPolicy
{
    use HandlesAuthorization;

    public function show(User $user , Groups $group)
    {
        return $user->id === $group->user_id ? Response::allow() : Response::deny('something went wrong');
    }
}
