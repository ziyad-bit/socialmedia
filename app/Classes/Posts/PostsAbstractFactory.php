<?php

namespace App\Classes\Posts;

use App\Classes\Posts\GroupPage;
use App\Classes\Posts\PostsPage;
use App\Classes\Posts\UsersProfilePage;

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
