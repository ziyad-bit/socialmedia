<?php

namespace App\Listeners;

use App\Models\Friends_user;
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Events\StoreFriendRequestEvent;

class StoreFriendRequestListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StoreFriendRequestEvent $event)
    {
        DB::beginTransaction();

        Friends_user::create($event->req_data);
        Notifications::create(['type'=>'friend_req','receiver_id'=>$event->receiver_id ] + $event->auth_user);

        DB::commit();

        $auth_id=Auth::id();
        Cache::forget('notifs_'.$auth_id);
        Cache::forget('notifs_count_'.$auth_id);
    }
}
