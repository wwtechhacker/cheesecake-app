<?php

class Attributes {

	public $attributes = array();
	public $parent;

	public function __construct($arr = array(), $parentReference)
	{
		$this->parent = $parentReference;
		if($arr !== array() and $arr != null) {

			foreach($arr as $k => $v)
			{
				$this->set_attribute($k,$v);
			}
		}
	}
	
	/**
	 * Get a given attribute from the model.
	 *
	 * @param  string  $key
	 */
	public function get_attribute($key)
	{
		return array_get($this->attributes, $key);
	}

	/***
	 * Set an attribute's value on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set_attribute($key, $value)
	{
		$this->attributes[$key] = $value;
		$this->parent->attr_save($this->attributes);
	}

	// 
	// DYNAMIC FUNCTIONS
	//

	/**
	 * Handle the dynamic retrieval of attributes and associations.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		// We will just assume the requested key is just a regular
		// attribute and attempt to call the getter method for it, which
		// will fall into the __call method if one doesn't exist.
		return $this->{"get_{$key}"}();
	}

	/**
	 * Handle the dynamic setting of attributes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->{"set_{$key}"}($value);
	}

	/**
	 * Determine if an attribute exists on the model.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function __isset($key)
	{
		foreach (array('attributes', 'relationships') as $source)
		{
			if (array_key_exists($key, $this->$source)) return true;
		}

		if (method_exists($this, $key)) return true;
	}

	/**
	 * Remove an attribute from the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __unset($key)
	{
		unset($this->attributes[$key]);
	}

	/**
	 * Handle dynamic method calls on the model.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		// First we want to see if the method is a getter / setter for an attribute.
		// If it is, we'll call the basic getter and setter method for the model
		// to perform the appropriate action based on the method.
		if (starts_with($method, 'get_'))
		{
			return $this->get_attribute(substr($method, 4));
		}
		elseif (starts_with($method, 'set_'))
		{
			$this->set_attribute(substr($method, 4), $parameters[0]);
		}
	}
}