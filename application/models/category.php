<?php

use Laravel\Database\Eloquent\Query;

class Category extends Eloquent {
	
	public static $table = "forums";
	public $includes = array('forums');
	
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
		return with(new Query($this))->where('is_category','=','1');
	}
	
	public function forums()
	{
		return $this->has_many('Forum','parent_id');
	}
	
}