<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admins;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();

        for ($i=0; $i <1000 ; $i++) { 
            User::create([
                'name'              => $faker->unique()->name(),
                'photo'             => 'user.jpg',
                'email'             => $faker->unique()->email(),
                'email_verified_at' => now(),
                'online'            => 0,
                'password'          => Hash::make('12121212'),                // password
                'remember_token'    => Str::random(10),
            ]); 

            if ($i > 50) {
                $user=User::find(56);
                $users=User::inRandomOrder()->take(10)->pluck('id')->toArray();
                $user->auth_add_friends()->attach($users);
            }
           
            
        }
        
    }
}
