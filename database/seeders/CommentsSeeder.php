<?php

namespace Database\Seeders;

use App\Models\Comments;
use App\Models\Posts;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=collect(User::all()->modelKeys());
        $posts=collect(Posts::all()->modelKeys());
        $faker=Factory::create();

        for ($i=0; $i <100 ; $i++) { 
            Comments::create([
                'text'    => $faker->sentence(),
                'user_id' => $users->random(),
                'post_id' => $posts->random(),
            ]);
        }
    }
}
