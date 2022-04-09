<?php

namespace App\Classes\Posts;

use App\Classes\Posts\GroupPage;
use App\Classes\Posts\PostsPage;
use App\Classes\Posts\ProfilePage;

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

    public function profilePage():ProfilePage
    {
        return new ProfilePage();
    }
}
