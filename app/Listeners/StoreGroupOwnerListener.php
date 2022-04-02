<?php

namespace App\Listeners;

use App\Events\StoreGroupOwner;
use App\Models\Group_users;
use App\Models\Roles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class StoreGroupOwnerListener
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
     * @param  \App\Events\StoreGroupOwner  $event
     * @return void
     */
    public function handle(StoreGroupOwner $event)
    {
        Group_users::create([
            'user_id'  => Auth::id(),
            'group_id' => $event->group_id,
            'role_id'  => Roles::group_owner,
            'status'   => Group_users::approved_req,
        ]);
    }
}
