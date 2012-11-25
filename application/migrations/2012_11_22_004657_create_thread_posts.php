<?php

class Create_Thread_Posts {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$arr = array('1','2','3','4');
		$post = array('a','b','c');
		foreach($arr as $a)
		{
			$parent = DB::table('posts')->insert(array(
					'parent_id' => '2',
					'is_thread' => '1',
					'user_id' => '1',
					'title' => $a,
					'content' => "This is post #".$a,
			));
			foreach($post as $p)
			{
				$parent = (((int)$a - 1) * 4) + 1;
				DB::table('posts')->insert(array(
						'parent_id' => $parent,
						'is_thread' => '0',
						'user_id' => '1',
						'content' => $p,
				));
			}
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
		$affected = DB::table('posts')->delete();
	}

}