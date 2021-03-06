<?php

class User extends Eloquent {

	// public function __construct()
	// {
	// 	// parent::__construct();
	// 	// $this->attr = new Attributes(json_decode($this->properties, true));
	// }

	public static $timestamps = true;
	public $attr = null;

	// Relationship functions
	
	public function posts()
	{
		return $this->has_many('Post');
	}
	public function threads()
	{
		return $this->has_many('Thread');
	}

	// Permission functions.

	public function roles()
	{
		return $this->has_many_and_belongs_to('Role', 'role_user');
	}

	public function has_role($key)
	{
		foreach($this->roles as $role)
		{
			if($role->name == $key)
			{
				return true;
			}
		}

		return false;
	}

	public function has_any_role($keys)
	{
		if( ! is_array($keys))
		{
			$keys = func_get_args();
		}

		foreach($this->roles as $role)
		{
			if(in_array($role->name, $keys))
			{
				return true;
			}
		}

		return false;
	}

	public function set_password($password)
	{
		$this->set_attribute('password', Hash::make($password));
	}

	public function attr()
	{
		if($this->attr === null)$this->attr = new Attributes(json_decode($this->properties, true),$this);
		return $this->attr;
	}
	public function attr_save($attributes = array())
	{
		$this->set_attribute('properties',$attributes);
	}
}