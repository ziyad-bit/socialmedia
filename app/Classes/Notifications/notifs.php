<?php

namespace App\Classes\Notifications;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Notifs{
    public static function get(int $last_notif_id):Collection
    {
        return Notifications::forAuth()->where('id','<',$last_notif_id)
            ->orderByDesc('id')->limit(3)->get();
    }

    public static function get_ids():array
    {
        return Notifications::where(['seen'=>0,'receiver_id'=>Auth::id()])->pluck('id')->toArray();
    }
}