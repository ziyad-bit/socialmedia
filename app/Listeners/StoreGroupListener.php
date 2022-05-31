<?php

namespace App\Listeners;

use App\Models\Roles;
use App\Models\Groups;
use App\Events\StoreGroup;
use App\Models\Group_users;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Services\SlugService;

class StoreGroupListener
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
    public function handle(StoreGroup $event)
    {
        $slug  = SlugService::createSlug(Groups::class,'slug',$event->request->name );

        $group = Groups::create($event->request->except('photo')+[  'photo'   => $event->photo_name,
                                                                    'slug'    => $slug,
                                                                    'user_id' => Auth::id()]);

        Group_users::create([
            'user_id'  => Auth::id(),
            'group_id' => $group->id,
            'role_id'  => Roles::group_owner,
            'status'   => Group_users::approved_req,
        ]);
    }
}
