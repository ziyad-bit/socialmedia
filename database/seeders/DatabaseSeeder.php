<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		//$this->call(UsersSeeder::class);
		$this->call(AdminsSeeder::class);
		$this->call(GroupsSeeder::class);
		$this->call(RolesSeeder::class);
		$this->call(PostsSeeder::class);
		$this->call(LikesSeeder::class);
		$this->call(SharesSeeder::class);
		$this->call(CommentsSeeder::class);
		$this->call(MessagesSeeder::class);
		$this->call(LanguagesSeeder::class);
	}
}
