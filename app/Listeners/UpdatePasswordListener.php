<?php

namespace App\Listeners;

use App\Events\UpdatePasswordEvent;
use App\Models\Admins;
use App\Models\Password_reset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordListener
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle the event.
	 *
	 * @param  \App\Events\UpdatePasswordEvent  $event
	 *
	 * @return void
	 */
	public function handle(UpdatePasswordEvent $event)
	{
		DB::beginTransaction();

		$email=$event->email;

		Password_reset::where('email', $email)->delete();

		Admins::where('email', $email)
			->update(['password'=>Hash::make($event->password)]);

		DB::commit();
	}
}
