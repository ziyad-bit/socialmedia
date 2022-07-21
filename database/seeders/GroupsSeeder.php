<?php

namespace Database\Seeders;

use App\Models\Groups;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = collect(User::all()->modelKeys());
		$faker = Factory::create();

		for ($i = 0; $i < 10; $i++) {
			$group = Groups::create([
				'name'        => $faker->word(),
				'user_id'     => $users->random(),
				'description' => $faker->paragraph(),
				'photo'       => '0c1g15lpwtk85PuMtW9WndK8RLPwMp90wwBgJj9h.jpg',
			]);

			$users2 = User::inRandomOrder()->take(3)->pluck('id')->toArray();
			$group->group_users()->attach($users2);
		}
	}
}
