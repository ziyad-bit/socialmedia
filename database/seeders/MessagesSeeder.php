<?php

namespace Database\Seeders;

use App\Models\Messages;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MessagesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users=collect(User::all()->modelKeys());
		$faker=Factory::create();

		for ($i=0; $i<1000; $i++) {
			Messages::create([
				'receiver_id'=>$users->random(),
				'sender_id'=>$users->random(),
				'text'=>$faker->sentence(),
			]);
		}
	}
}
