<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('handle')->unique();
            $table->string('profile_photo')->nullable();
            $table->string('background_photo')->nullable();
            $table->string('bio')->nullable();
            $table->string('website')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->boolean('active');
            $table->string('activation_token', 256)->nullable();
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
		Schema::drop('users');
	}

}
