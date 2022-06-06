<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0)->comment('0 = join request , 1 = approved , 2 = ignored');
            $table->tinyInteger('punish')->default(0)->comment('0 = false , 1 = true ');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('role_id')->default(null)->constrained('roles')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('group_users');
    }
}
