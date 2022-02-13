<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Posts;
use App\Models\Shares;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

trait Shared_posts_ids
{
    public function getSharedPostsIds(array $friends_ids):array
    {
        return Shares::whereIn('user_id',$friends_ids)->pluck('post_id')->toArray();
    }
}
