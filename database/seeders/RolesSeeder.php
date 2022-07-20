<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Roles::create([
			'name'=>'group_member',
			'description'=>'basic permission',
		]);

		Roles::create([
			'name'=>'group_admin',
			'description'=>'mid level permission',
		]);

		Roles::create([
			'name'=>'group_owner',
			'description'=>'all permissions',
		]);
	}
}
