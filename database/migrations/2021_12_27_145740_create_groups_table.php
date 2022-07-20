<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('slug',50)->unique();
            $table->string('photo',100);
            $table->text('description');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('groups');
    }
}
