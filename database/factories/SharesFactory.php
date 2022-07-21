<?php

namespace Database\Factories;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SharesFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$posts = collect(Posts::all()->modelKeys());
		$users = collect(User::all()->modelKeys());

		return [
			'post_id' => $posts->random(),
			'user_id' => $users->random(),
		];
	}
}
