<?php

namespace Database\Seeders;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = collect(User::all()->modelKeys());

		for ($i = 0; $i < 10; $i++) {
			Notifications::create([
				'type'        => 'friend_request',
				'seen'        => rand(0, 1),
				'receiver_id' => $users->random(),
				'user_id'     => $users->random(),
			]);
		}
	}
}
