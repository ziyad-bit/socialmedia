<?php

namespace App\Listeners;

use App\Events\UpdateGroupOwner;
use App\Models\Roles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateGroupOwnerListener
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
    public function handle(UpdateGroupOwner $event)
    {
        $event->group_admin->update(['role_id'=>Roles::group_owner]);
    }
}
