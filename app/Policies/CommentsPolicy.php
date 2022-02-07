<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comments;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentsPolicy
{
    use HandlesAuthorization;

    public function update_or_delete(User $user,Comments $comments)
    {
        return $user->id === $comments->user_id ? Response::allow() : Response::deny('something went wrong');
    }
}
