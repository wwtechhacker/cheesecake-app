<?php

class User_Controller extends Base_Controller {
	
	public $restful = true;
	public $layout = 'default';
	
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

		$credentials = array('username' => $username,'password' => $password,'remember' => $remember);
		
		$valid_login = Auth::attempt($credentials);
		if($valid_login)return Redirect::home();//to_route('admin.user.list');
		else return Redirect::to_route('auth.login')->with('error','Login attempt failed');
	}
	
	public function get_logout()
	{
		Auth::logout();
		return Redirect::home();
	}

	// REGISTRATION
	public function get_register()
	{
		$this->layout->title = Config::get('site.name') . ' - Register';
		$this->layout->content = View::make('auth.register');
	}
	public function post_register()
	{
		$input = Input::all();

		$email = $input["email"];
		if(!User::where('email','=',$email)->first())
		{
			// User doesn't exist
			$user = new User();
			$user->email = $email;
			$user->password = $input["password"];
			$user->name = $input["name"];

			$user->save();
			Auth::login($user->id);

			return Redirect::home();
			//if(Session::has('page'))return Redirect::to_route(Session::get('page'));
			//else return Redirect::home();
		}

	}
	// END REGISTRATION
	
}