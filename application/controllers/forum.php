<?php

class Forum_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'default';
	
	public function get_index()
	{
		$categories = Category::all();
		
		$this->layout->title = 'Hi.';
		$this->layout->content = View::make('forum.index')
						->with('categories',$categories);
	}
	
	public function get_board($id)
	{
		$threads = Thread::all();

		$this->layout->title = "Board " . $id;
		$this->layout->content = View::make('forum.board')
						->with('threads',$threads)
						->with('boardid',$id);
	}
	
	public function get_thread($boardid,$threadid,$slug="")
	{
		$thread = Thread::find($threadid);
		$latestpost = $thread->latest_post();
		$this->layout->title = "Thread " . $boardid . " " . $threadid;
		$this->layout->content = "Lulz " . $boardid . " " . $threadid;
	}
	
}