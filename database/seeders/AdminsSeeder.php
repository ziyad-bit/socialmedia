<?php

namespace Database\Seeders;

use App\Models\Admins;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();

        for ($i=0; $i <10 ; $i++) { 
            Admins::create([
                'name'     => 'ziyad',
                'photo'    => 'user.jpg',
                'email'    => $faker->unique()->email(),
                'password' => Hash::make('12121212'),
            ]);
        }
        
    }
}
