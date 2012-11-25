<?php

class Admin_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'admin.default';
	
	public function get_index()
	{
		$this->layout->title = 'Hi.';
		$this->layout->content = View::make('admin.index');
	}
	
	public function get_login()
	{
		$this->layout->title = Config::get('site.name') . ' - Login';
		$this->layout->content = View::make('auth.login');
	}
	public function post_login()
	{
		$username = Input::get('username');
		$password = Input::get('password');
		$remember = (Input::get('remember') == 1) ? true : false;
		
		$valid_login = Sentry::login($username,$password,$remember);
		if($valid_login)return Redirect::to_route('admin.user.list');
		else return Redirect::to_route('auth.login')->with('error','Login attempt failed');
	}
	
	public function get_logout()
	{
		Sentry::logout();
		return Redirect::home();
	}
	
}