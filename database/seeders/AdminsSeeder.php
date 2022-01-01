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
                'name'     => 'ziyad'.$i,
                'email'    => 'ziyad199523'.$i.'@yahoo.com',
                'password' => Hash::make('12121212'),
            ]);
        }
        
    }
}
