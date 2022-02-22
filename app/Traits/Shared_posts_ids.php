<?php

namespace App\Traits;

use App\Models\Shares;

trait Shared_posts_ids
{
    public function getSharedPostsIds(array $friends_ids):array
    {
        $share_post_ids= Shares::whereIn('user_id',$friends_ids)->pluck('post_id')->toArray();

        $share_post_ids=array_unique($share_post_ids);
        return $share_post_ids;
    }
}
