<?php

use Laravel\Database\Eloquent\Query;

class Forum extends Eloquent {
	
	public static $table = "forums";
	
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
		return with(new Query($this))->where('is_category','=','0');
	}
	
	public function category()
	{
		return $this->belongs_to('Category','parent_id');
	}
	
}
