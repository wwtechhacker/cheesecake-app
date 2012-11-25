<?php

class Make_More_Categories {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$arr = array('1','2','3','4');
		foreach($arr as $a)
		{
			DB::table('forums')->insert(array('is_category' => '1','name' => $a,'weight' => (int)$a));
		}
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		$affected = DB::table('forums')->where('id', '>', 2)->delete();
	}

}