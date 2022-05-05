<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update_or_delete(User $user,Posts $post)
    {
        return $user->id === $post->user_id ? Response::allow() : Response::deny('something went wrong');
    }
}
