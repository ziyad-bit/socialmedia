<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'id'          => rand(1,3),
            'name'        => $this->faker->name(),
            'description' => $this->faker->sentence(),
        ];
    }
}
