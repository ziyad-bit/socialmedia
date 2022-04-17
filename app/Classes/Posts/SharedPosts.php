<?php

namespace App\Classes\Posts;

use App\Models\Shares;

class SharedPosts 
{
    public static function get_ids(array $friends_ids):array
    {
        $share_post_ids= Shares::whereIn('user_id',$friends_ids)->orderByDesc('id')
            ->limit(20)->pluck('post_id')->toArray();

        $share_post_ids=array_unique($share_post_ids);
        return $share_post_ids;
    }
}
