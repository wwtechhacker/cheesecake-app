<?php

class Admin_User_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'admin.default';
	
	public function get_list()
	{
		try
		{
			$users = Sentry::user()->all();
			
			$this->layout->title = "List | User | " . Config::get('site.name');
			$this->layout->content = View::make('admin.user.list')
										->with('users',$users);
		}
		catch (Sentry\SentryException $e)
		{
		    dd($e->getMessage()); // catch errors such as user not existing or bad fields
		}
	}
	
	public function get_delete($id)
	{
		if($id == 1)
			return Redirect::to_route('admin.user.list')->with('error','Cannot delete root user.');
		try
		{
			$user = Sentry::user($id);
			$delete = $user->delete();
			
			if($delete)
				return Redirect::to_route('admin.user.list');
			else {
				return Redirect::to_route('admin.user.list')
							->with('error','Cannot delete user#'.$id);
			}
		}
		catch (Sentry\SentryException $e)
		{
			dd($e->getMessage());
		}
	}
	
	public function get_edit($id = false)
	{
		if($id==FALSE)
			return Redirect::to_route('admin.user.list')->with('error','Cannot edit null user.');
		
		try
		{
			$user = Sentry::user((int)$id);
			
			$this->layout->title = "Edit | User | " . Config::get('site.name');
			$this->layout->content = View::make('admin.user.edit')
										->with('user',$user);
		}
		catch (Sentry\SentryException $e)
		{
			dd($e->getMessage());
		}
		
	}
	
	public function post_edit($id)
	{
		$input = Input::all();
		
		$rules = array(
				'email' => 'required|email',
				'username' => 'required',
				'last_name' => 'required_with:first_name',
				);
		
		$validation = Validator::make($input,$rules);
		if($validation->fails())
		{
			dd($validation->errors);
		}
		
		try
		{
			$vars = array(
				'email' => $input['email'],
				'username' => $input['username'],
				'metadata' => array(
						'first_name' => $input['first_name'],
						'last_name' => $input['last_name'],
						),
				);
			$user = Sentry::user((int)$id);
			$update = $user->update($vars);
			
			if($update)return Redirect::to_route('admin.user.list');
			else return Redirect::to_route('admin.user.list')->with('error','Edit failed');
		}
		catch (Sentry\SentryException $e)
		{
			dd($e->getMessage());
		}
	}
	
}