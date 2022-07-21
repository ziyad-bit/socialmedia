<?php

namespace Database\Seeders;

use App\Models\Posts;
use App\Models\Shares;
use App\Models\User;
use Illuminate\Database\Seeder;

class SharesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = collect(User::all()->modelKeys());
		$posts = collect(Posts::all()->modelKeys());

		for ($i = 0; $i < 1000; $i++) {
			Shares::create([
				'user_id' => $users->random(),
				'post_id' => $posts->random(),
			]);
		}
	}
}
