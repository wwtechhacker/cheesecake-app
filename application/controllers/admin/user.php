<?php

class Admin_User_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'admin.default';
	
	public function get_list()
	{
		$users = User::all();

		$this->layout->title = Config::get('site.name') . " - List Users";
		$this->layout->content = View::make('admin.user.list')
										->with('users',$users);
	}
	
	public function get_delete($id)
	{
		if($id == 1 or $id == Auth::user()->id)
			return Redirect::to_route('admin.user.list')->with('error','Cannot delete user.');

		$user = User::find($id);
		if(!$user)return Redirect::to_route('admin.user.list')->with('error','Cannot find user.');

		$user->delete();

		return Redirect::to_route('admin.user.list');
	}
	
	public function get_edit($id)
	{
		if(!($id > 0))
			return Redirect::to_route('admin.user.list')->with('error','Cannot edit null user.');

		$user = User::find($id);
		if(!$user)return Redirect::to_route('admin.user.list')->with('error','Cannot find user.');

		$this->layout->title = Config::get('site.name') . " - Edit user";
		$this->layout->content = View::make('admin.user.edit')
										->with('user',$user);
		
	}
	
	public function post_edit($id)
	{
		$input = Input::all();
		
		$rules = array(
				'email' => 'required|email',
				'name' => 'required',
				);
		
		$validation = Validator::make($input,$rules);
		if($validation->fails())
		{
			dd($validation->errors);
		}

		$user = User::find($id);
		if(!$user)return Redirect::to_route('admin.user.list')->with('error','Cannot find user.');

		$user->email = Input::get('email');
		$user->name = Input::get('name');
		if(Input::get('password') != "")
				$input->password = Input::get('password');

		$user->save();

		return Redirect::to_route('admin.user.list');
	}
	
}