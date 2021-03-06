<?php

namespace Database\Seeders;

use App\Models\Group_users;
use App\Models\Groups;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupUsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users  = collect(User::all()->modelKeys());
		$roles  = collect(Roles::all()->modelKeys());
		$groups = collect(Groups::all()->modelKeys());

		for ($i = 0; $i < 1000; $i++) {
			Group_users::create([
				'role_id'  => $roles->random(),
				'user_id'  => $users->random(),
				'group_id' => $groups->random(),
				'status'   => 1,
			]);
		}
	}
}
