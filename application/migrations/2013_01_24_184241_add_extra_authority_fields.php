<?php

class Add_Extra_Authority_Fields {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('users', function($table)
		{
			$table->integer('age');
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
		Schema::table('users', function($table)
		{
			$table->drop_column('age');
		});
	}

}