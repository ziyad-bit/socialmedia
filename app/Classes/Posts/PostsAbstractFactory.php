<?php

namespace App\Classes\Posts;

class PostsAbstractFactory
{
	public function groupPage():GroupPage
	{
		return new GroupPage();
	}

	public function postsPage():PostsPage
	{
		return new PostsPage();
	}

	public function usersProfilePage():UsersProfilePage
	{
		return new UsersProfilePage();
	}
}
