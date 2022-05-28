<?php

namespace App\Classes\Posts;

use App\Models\Group_users;
use App\Models\Shares;
use Illuminate\Support\Facades\Auth;

class Posts 
{
    public static function getSharedIds(array $friends_ids):array
    {
        $share_post_ids = Shares::whereIn('user_id',$friends_ids)->orderByDesc('id')
            ->limit(20)->pluck('post_id')->toArray();

        return array_unique($share_post_ids);
    }
}
