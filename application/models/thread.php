<?php

use Laravel\Database\Eloquent\Query;

class Thread extends Eloquent {
	
	public static $table = "posts";
	public $includes = array('posts');
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
		return with(new Query($this))->where('is_thread','=','1');
	}
	
	public function posts()
	{
		return $this->has_many('Post','parent_id');
	}

	public function latest_post()
	{
		$post = with(new Query($this))->order_by('created_at','desc')->get();
	}

	public function latest_poster()
	{
		$post = self::latest_post();

		if(count($post))
		{
			$post = $post[0];
			$user = Sentry::user($post->user_id);
			$info = $user->get(array('username','metadata'));

			
			return $combined;
		}
	}
	
}