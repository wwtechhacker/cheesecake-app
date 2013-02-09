<?php

class Create_Forum {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('forums', function($table)
		{
			$table->increments('id');
			$table->boolean('is_category');
			$table->integer('parent_id')->unsigned();
			$table->string('name');
			$table->string('description');
			$table->integer('weight');
			$table->integer('latest_thread_id')->unsigned();

			$table->timestamps();
		});

		$category = new Category();
		$category->is_category = 1;
		$category->name = "Uncategorised";
		$category->description = "The general category for new boards.";
		$category->weight = 1;
		$category->save();

		$forum = new Forum();
		$forum->is_category = 0;
		$forum->name = "General";
		$forum->parent_id = 1;
		$forum->description = "General chat, congregate here.";
		$forum->weight = 1;
		$forum->latest_thread_id = 1;
		$forum->save();

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('forums');
	}

}