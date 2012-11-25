<?php

use Laravel\Database\Eloquent\Query;

class Post extends Eloquent {
	
	public static $table = "posts";
	public static $timestamps = true;
	
	/**
	 * Get a new fluent query builder instance for the model.
	 * This is being overwritten so that we're able to run
	 * two different Eloquent relational models from one
	 * Database table.
	 *
	 * @return Query
	 */
	protected function query()
	{
		return with(new Query($this))->where('is_thread','=','0');
	}
	
	public function thread()
	{
		return $this->belongs_to('Thread','parent_id');
	}
	
}




