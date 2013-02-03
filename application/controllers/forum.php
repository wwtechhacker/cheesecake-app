<?php

class Forum_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'default';
	
	public function get_index()
	{
		$categories = Category::with('forums')->get();
		$bread = Breadcrumb::create(array('Home'));
		
		$this->layout->title = 'Hi.';
		$this->layout->content = View::make('forum.index')
						->with('categories',$categories)
						->with('breadcrumb',$bread);
	}

	public function get_category($id)
	{
		$categories = Category::with('forums')->where('id','=',$id)->get();
		$bread = Breadcrumb::create(array(
					'Home' => URL::to_route('forum.home'),
					$categories[0]->name
				));

		$this->layout->title = "lulz";
		$this->layout->content = View::make('forum.index')
						->with('categories', $categories)
						->with('breadcrumb', $bread);
	}
	
	public function get_board($id)
	{
		$threads = Thread::with(array('poster','latest_poster'))
								->where('board_id','=',$id)
								->order_by('stickied','desc')
								->order_by('created_at','desc')
								->get();

		// Start making the breadcrumbs
		$board = Forum::with('parent')->where('id','=',$id)->first();
		$cat = $board->category;
		$bread = Breadcrumb::create(array(
					'Home' => URL::to_route('forum.home'),
					$cat->name => URL::to_route('forum.category',array($cat->id)),
					$board->name
				));

		$this->layout->title = "Board " . $id;
		$this->layout->content = View::make('forum.board')
						->with('threads',$threads)
						->with('boardid',$id)
						->with('breadcrumb',$bread);
	}
	
	public function get_thread($threadid)
	{
		$thread = Thread::find($threadid);
		$posts = Post::with('user')->where('thread_id','=',$threadid)->get();

		$board = Forum::with('parent')->where('id','=',$thread->board_id)->first();
		$cat = $board->category;

		$bread = Breadcrumb::create(array(
					'Home' => URL::to_route('forum.home'),
					$cat->name => URL::to_route('forum.category',array($cat->id)),
					$board->name => URL::to_route('forum.board',array($board->id)),
					$thread->title
				));

		$this->layout->title = "Thread " . $threadid;
		$this->layout->content = View::make('forum.thread')
						->with('thread',$thread)
						->with('posts',$posts)
						->with('breadcrumb', $bread);
	}

	// Creating a new thread
	public function get_newThread($boardid)
	{
		$this->layout->title = "";
		$this->layout->content = View::make('forum.thread.new');
	}
	public function post_newThread($boardid)
	{
		$uid = Auth::user()->id;
		
		$thread = new Thread(array('board_id' => $boardid,'user_id' => $uid,'title' => Input::get('title'),
									'post_count' => 1, 'latest_post_at' => with(new \DateTime), 'latest_user_id' => $uid));
		$thread->save();
		$post = new Post(array('user_id' => $uid,'content' => Input::get('content')));


		$thread->posts()->insert($post);

		$postid = $post->get_key();
		$thread->post_id = $postid;
		$thread->latest_post_id = $postid;
		$thread->save();

		$board = Forum::find($boardid);
		$board->latest_thread_id = $thread->id;
		$board->save();

		return Redirect::to_route('forum.board',array($boardid));
	}
	// End creating a new thread

	// Creating a new post
	public function get_newReply($threadid)
	{
		$this->layout->title = 'Reply to Thread#'.$threadid;
		$this->layout->content = View::make('forum.thread.reply');
	}
	public function post_newReply($thread_id)
	{
		$thread = Thread::find($thread_id);

		// Make the post
		$post = new Post(array('user_id' => Auth::user()->id,'content' => Input::get('content')));
		$thread->posts()->insert($post);

		// Update thread information. Such as when the latest post was, who the latest poster was, etc.
		$thread->latest_post_at = new \DateTime;
		$thread->latest_user_id = Auth::user()->id;
		$thread->latest_post_id = $post->id;
		$thread->post_count++;
		$thread->save();

		return Redirect::to_route('forum.thread',array($thread_id));
	}
	// End creating a new post
	
}