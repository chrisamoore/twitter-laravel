<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('message');

            $table->integer('from_user_id')->unsigned()->index();
            $table->foreign('from_user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->integer('to_user_id')->unsigned()->index();
            $table->foreign('to_user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

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
		Schema::drop('messages');
	}

}
