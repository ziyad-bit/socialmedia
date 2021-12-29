<?php

namespace Database\Seeders;

use App\Models\Groups;
use App\Models\Posts;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=collect(User::all()->modelKeys());
        $groups=collect(Groups::all()->modelKeys());
        $faker=Factory::create();

        for ($i=0; $i <100 ; $i++) { 
            Posts::create([
                'text'=>$faker->paragraph(),
                'user_id'=>$users->random(),
                'group_id'=>$groups->random(),
                'photo'=>'https://via.placeholder.com/150',
            ]);
        }
    }
}
