<?php

namespace App\Listeners;

use App\Models\Roles;
use App\Models\Groups;
use App\Events\StoreGroup;
use App\Models\Group_users;
use Illuminate\Support\Facades\DB;
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

        if ($event->is_admin == true) {
            $owner=['admin_id' => Auth::id()];
        }else{
            $owner=['user_id' => Auth::id()];
        }

        DB::beginTransaction();
        
        $group = Groups::create($event->request->except('photo')+[  'photo'   => $event->photo_name,
                                                                    'slug'    => $slug,
                                                                    ]+$owner);

        Group_users::create([
            'group_id' => $group->id,
            'role_id'  => Roles::group_owner,
            'status'   => Group_users::approved_req,
        ]+$owner);

        DB::commit();
    }
}
