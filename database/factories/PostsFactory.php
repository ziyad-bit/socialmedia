<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Groups;
use App\Models\Posts;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostsFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users  = collect(User::all()->modelKeys());
        $groups = collect(Groups::all()->modelKeys());

        return [
            'text'     => $this->faker->paragraph(),
            'user_id'  => $users->random(),
            'group_id' => $groups->random(),
            'photo'    => $this->faker->word(),
        ];
    }
}
