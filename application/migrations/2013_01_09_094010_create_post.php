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
			$table->integer('thread_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('content');
			
			$table->timestamps();
		});

		$thread = new Thread();
		$thread->board_id = 2;
		$thread->post_id = 1;
		$thread->user_id = 1;
		$thread->latest_post_id = 1;
		$thread->latest_user_id = 1;
		$thread->post_count = 1;
		$thread->title = "Testing...";
		$thread->save();

		$post = new Post();
		$post->thread_id = 1;
		$post->user_id = 1;
		$post->content = "This was a triumph... I'm making a note here... Huge Success.";
		$post->save();
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