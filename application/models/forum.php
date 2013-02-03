<?php

use Laravel\Database\Eloquent\Query;

class Forum extends Eloquent {
	
	public static $table = "forums";
	public $includes = array('threads','latest_thread','parent');
	
	
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

	public function parent()
	{
		return $this->belongs_to('Forum','parent_id');
	}

	public function threads()
	{
		return $this->has_many('Thread','board_id');
	}

	public function latest_thread()
	{
		return $this->belongs_to('Thread','latest_thread_id');
	}
	
}
