<?php

namespace Database\Seeders;

use App\Models\Groups;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=collect(User::all()->modelKeys());
        $faker=Factory::create();

        for ($i=0; $i <10 ; $i++) { 
            Groups::create([
                'name'=>$faker->word(),
                'user_id'=>$users->random(),
                'description'=>$faker->paragraph(),
                'status' => rand(0, 1),
                'photo'=>'https://via.placeholder.com/150',
            ]);
        }
    }
}
