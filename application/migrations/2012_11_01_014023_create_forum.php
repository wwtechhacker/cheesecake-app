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
		});
		
		DB::table('forums')->insert(array(
					'is_category' => 1,
					'name' => 'Uncategorised',
					'description' => 'The general category.',
					'weight' => 1,
					));	
		DB::table('forums')->insert(array(
					'parent_id' => 1,
					'name' => 'General',
					'description' => 'General chat, congregate here.',
					'weight' => 1,
					));
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