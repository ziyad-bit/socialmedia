<?php

namespace Database\Seeders;

use App\Models\Admins;
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
        for ($i=0; $i <10 ; $i++) { 
            Admins::create([
                'name'     => 'ziyad',
                'photo'    => 'user.jpg',
                'email'    => 'ziyad199523102'.$i.'@yahoo.com',
                'password' => Hash::make('12121212'),
            ]);
        }
        
    }
}
