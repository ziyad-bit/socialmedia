<?php

namespace App\Policies;

use App\Models\Group_users;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Group_usersPolicy
{
	use HandlesAuthorization;

	//##############################     owner    ##########################################
	public function owner(User $user, Group_users $group_auth): Response
	{
		return $group_auth->user_id == $user->id && $group_auth->role_id === Roles::group_owner ? Response::allow() : Response::deny('something went wrong');
	}

	//##############################     owner_admin    ##########################################
	public function owner_admin(User $user, Group_users $group_auth): Response
	{
		return $group_auth->user_id == $user->id && $group_auth->role_id === Roles::group_owner || $group_auth->role_id === Roles::group_admin ? Response::allow() : Response::deny('something went wrong');
	}

	//##############################     owner_admins_member   ##########################################
	public function owner_admin_member(User $user, Group_users $group_auth): Response
	{
		return $group_auth->user_id == $user->id && $group_auth->role_id !== null ? Response::allow() : Response::deny('something went wrong');
	}

	//##############################      auth_not_punished    ##########################################
	public function auth_not_punished(User $user, Group_users $group_auth): Response
	{
		return $group_auth->user_id == $user->id && $group_auth->punish !== Group_users::punished ? Response::allow() : Response::deny('something went wrong');
	}

	//##############################      not_punished    ##########################################
	public function not_punished(User $user, Pivot $group_user): Response
	{
		return $group_user->punish !== Group_users::punished ? Response::allow() : Response::deny('something went wrong');
	}
}
