<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
/*
posts =>  'photo','user_id','text','updated_at','created_at','file','video' , group_id

users

admins

messages => sender_id , receiver_id , message , updated_at , created_at 

groups => name , description , user_id ,  updated_at , created_at

group_users group_id , user_id , role_id

comments comment , user_id , post_id , updated_at , created_at

likes  user_id , post_id

shares user_id , post_id , updated_at , created_at

roles name , description


11801811863852041021

php artisan make:migration create_name_table
php artisan make:controller name -m 
php artisan make:model name -s
*/