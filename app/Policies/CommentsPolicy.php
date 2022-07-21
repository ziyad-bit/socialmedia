<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentsPolicy
{
	use HandlesAuthorization;

	public function update_or_delete(User $user, Comments $comments)
	{
		return $user->id === $comments->user_id ? Response::allow() : Response::deny('something went wrong');
	}
}
