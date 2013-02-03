<?php

class Create_Threads {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('threads', function($table)
		{
			$table->increments('id');
			$table->integer('board_id')->unsigned();
			$table->integer('post_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('latest_user_id')->unsigned();
			$table->integer('latest_post_id')->unsigned();
			$table->integer('post_count')->unsigned();
			$table->string('title'); 
			
			$table->timestamps();
			$table->date('latest_post_at');

			$table->boolean('locked')->default(0);
			$table->boolean('stickied')->default(0);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('threads');
	}

}