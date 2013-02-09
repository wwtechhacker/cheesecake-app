<?php

class Admin_Forum_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'admin.default';
	public $scripts = "";
	
	public function get_list()
	{
		$categories = Category::with('forums')->order_by('weight','asc')->get();

		$this->layout->title = Config::get('site.name') . " - View Forums";
		$this->layout->content = View::make('admin.forum.list')
										->with('categories',$categories);
	}
	public function post_list()
	{
		// Make sure that this is an ajax request.
		if(Request::ajax())
		{
			$list = Input::get('list');
			$forums = ForumCat::all();

			// Loop through all forums/categories
			foreach($forums as $f)
			{
				// Start a weight counter. We'll use this to tell how far through the
				// updated list the current forum is. This will be the new 'weight'
				// of the forum.
				$i = 1;
				// Loop through the updated list
				foreach($list as $k => $v)
				{
					// To find the current forum
					if($f->id == $k)
					{
						// Determine the new parent ID and whether it's now a category.
						$is_cat = ($v == "root") ? 1 : 0;
						$id = ($v == "root") ? 0 : $v;

						// Set the new information and save.
						$f->is_category = $is_cat;
						$f->parent_id = $id;
						$f->weight = $i;
						$f->save();
					}
					// Increment the weight counter, this wasn't the right one.
					else $i++;
				}
			}
			// We'll return this so the user actually knows that everything was
			// updated successfully.
			return "Success. Updates applied.";
		}
		// Return a nice catch-all to tell anyone who actually managed to submit
		// the form (aka have javascript turned off) to use javascript.
		return "Sorry, but you require Javascript to perform this action.";
	}

	public function post_add()
	{

		$ob = new ForumCat();
		$ob->is_category = 1;
		$ob->parent_id = 0;
		$ob->weight = 0;
		$ob->name = Input::get('name', 'Temp Name');
		$ob->description = Input::get('description', 'N/A');
		$ob->latest_thread_id = 0;
		$ob->save();

		// Return a success message if it's an ajax query
		if(Request::ajax())
		{
			return "Success. Object created.;".$ob->get_key().";".HTML::link_to_route('admin.forum.edit','[Edit]',array($ob->get_key()));
		}
		// Otherwise redirect the user to the forum list so they can manipulate
		// placings, etc.
		return Redirect::to_route('admin.forum.list');
	}
	
}