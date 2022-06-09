<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class Friends_userFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users  = collect(User::all()->modelKeys());

        return [
            'status'    => 1,
            'user_id'   => 1001,
            'friend_id' => $users->random(),
        ];
    }
}
