<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupsFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$users=collect(User::all()->modelKeys());

		return [
			'user_id'=>$users->random(),
			'name'=>$this->faker->name(),
			'photo'=>'KheHNgueMoDQO3TVSdWJAKh6PejfqV5WtMp9AQL3.jpg',
			'description'=>$this->faker->paragraph(2),
			'slug'=>$this->faker->name(),
		];
	}
}
