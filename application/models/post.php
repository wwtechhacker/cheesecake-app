<?php

class Post extends Eloquent {
	
	public static $timestamps = true;
	
	public function thread()
	{
		return $this->belongs_to('Thread');
	}

	public function user()
	{
		return $this->belongs_to('User');
	}
	
}