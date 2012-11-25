<?php

class Create_Post {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('posts', function($table)
		{
			$table->increments('id');
			$table->integer('parent_id')->unsigned();
			$table->boolean('is_thread');
			$table->integer('user_id')->unsigned();
			$table->string('title'); 
			$table->string('content');
			
			$table->timestamps();
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
		Schema::drop('posts');
	}

}