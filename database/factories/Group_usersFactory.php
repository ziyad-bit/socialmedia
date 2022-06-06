<?php

namespace Database\Factories;

use App\Models\Groups;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class Group_usersFactory extends Factory
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
        $roles  = collect(Roles::all()->modelKeys());

        return [
            'user_id'  => $users->random(),
            'group_id' => $groups->random(),
            'role_id'  => $roles->random(),
            'status'   => rand(0,2),
        ];
    }
}
