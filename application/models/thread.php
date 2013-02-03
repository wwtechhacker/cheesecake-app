<?php

class Thread extends Eloquent {
	
	public static $timestamps = true;

	public function post()
	{
		return $this->has_one('Post');
	}
	
	public function posts()
	{
		return $this->has_many('Post');
	}

	public function poster()
	{
		return $this->belongs_to('User','user_id');
	}

	public function board()
	{
		return $this->belongs_to('Board');
	}

	public function latest_post()
	{
		return $this->belongs_to('Post', 'latest_post_id');
		//return $this->posts()->order_by('created_at','desc')->first();
	}

	public function post_count()
	{
		return Post::where('thread_id','=',$this->thread_id)->count();
	}

	public function latest_poster()
	{
		return $this->belongs_to('User','latest_user_id');
	}

	public function sticky()
	{
		if(Auth::check() and Authority::can('sticky','Thread'))
			$this->stickied = $this->stickied ?: 0;
	}
	
}