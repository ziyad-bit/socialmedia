<?php

namespace App\Listeners;

use App\Models\Roles;
use App\Models\Groups;
use App\Events\UpdateGroupOwner;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        $event->group_admin->update(['role_id'=>Roles::group_owner]);
        
        $group=Groups::findOrFail($event->group_admin->group_id);
        $group->update(['user_id'=>$event->group_admin->user_id]);

        DB::commit();
    }
}
