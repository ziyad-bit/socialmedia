<?php

namespace Database\Seeders;

use App\Models\Admins;
use App\Models\User;
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
        for ($i=1; $i <100 ; $i++) { 
            $user=User::find($i);

            $users=User::inRandomOrder()->take(3)->pluck('id')->toArray();
            $user->auth_add_friends()->attach($users);
        }
        
    }
}
