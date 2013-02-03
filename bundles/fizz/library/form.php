<?php
/**
 * Fizz acts as a connector between Laravel's Form methods, and it's Validation
 * class, by setting some conventions by which the validators should be used, and making it's
 * data and errors accessible to the view.
 * 
 * All the form methods that Fizz provides are wrappers of the methods available
 * to Laravel\Form, the only difference being that Fizz will check for errors and then
 * add error classes to the elements that have failed validation. This allows users to easily
 * use a standard approach for handling both Forms, and Validation.
 *
 * @author Kirk Bushell
 * @date 30th Jan 2013
 * @version 1.2
 */
namespace Fizz;

use \Laravel\Config;
use \Laravel\Input;

class Form extends \Laravel\Form
{
	/**
	 * Stores access to the errors generated from validation.
	 *
	 * @var array
	 */
	private static $errors;

	/**
	 * Stores the values that may have added for field population. Values
	 * should be stored as an associative array, with the index as the name
	 * of the field, and the value as the field's value.
	 *
	 * @var array
	 */
	private static $values;

	/**
	 * Stores the errors that have been created at some point during
	 * the validation process - either during the first request,
	 * or as part of another. For values, if this is not defined, Fizz
	 * will look at two separate methods : Input::get() and Input::old().
	 * Input::old will be checked first, with Input::get() set as the default
	 * if either old() or $values array is empty.
	 * 
	 * @param array $errors
	 * @param array $values - Associative array of form field values
	 */
	public static function set_data($errors = array(), $values = array())
	{
		self::$errors = $errors;
		
		if ($values)
			self::$values = $values;
		else {
			$old = array_except(Input::old(), array('csrf_token'));
			if ($old)
				self::$values = $old;
			else
				self::$values = Input::get() ?: array();
		}
	}

	/**
	 * Does the meaty work, checking for existing values, field
	 * highlighting.etc.
	 *
	 * @return array First element is the value for the element, 2nd is the modified attributes array
	 */
	private static function _fizzle($name, $value, $attributes) {
		$value      = self::_handle_value($name, $value);
		$attributes = self::_check($name, $attributes);

		return array($value, $attributes);
	}

	/**
	 * Text field
	 */
	public static function text($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::text($name, $value, $attributes);
	}

	/**
	 * Password field
	 */
	public static function password($name, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, '', $attributes);
		return parent::password($name, $attributes);
	}

	/**
	 * Hidden field
	 */
	public static function hidden($name, $value = null, $attributes = array())
	{
		$value = self::_handle_value($name, $value);
		return parent::hidden($name, $value, $attributes);
	}

	/**
	 * Search field
	 */
	public static function search($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::search($name, $value, $attributes);
	}

	/**
	 * Email field
	 */
	public static function email($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::email($name, $value, $attributes);
	}

	/**
	 * Telephone field
	 */
	public static function telephone($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::telephone($name, $value, $attributes);
	}

	/**
	 * URL field
	 */
	public static function url($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::url($name, $value, $attributes);
	}

	/**
	 * Number field
	 */
	public static function number($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::number($name, $value, $attributes);
	}

	/**
	 * Date field
	 */
	public static function date($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::date($name, $value, $attributes);
	}

	/**
	 * Textarea field
	 */
	public static function textarea($name, $value = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::textarea($name, $value, $attributes);
	}

	/**
	 * Select field
	 */
	public static function select($name, $options = array(), $selected = null, $attributes = array())
	{
		list($value, $attributes) = self::_fizzle($name, $selected, $attributes);
		return parent::select($name, $options, $value, $attributes);
	}

	/**
	 * Checkbox field
	 */
	public static function checkbox($name, $value = 1, $checked = false, $attributes = array())
	{
		$set_value = self::$values($name);
		if ($set_value) {
			$checked = true;
		}

		list($value, $attributes) = self::_fizzle($name, $value, $attributes);
		return parent::checkbox($name, $value, $checked, $attributes);
	}

	/**
	 * Radio field
	 */
	public static function radio($name, $value = null, $checked = false, $attributes = array())
	{
		$set_value = self::$values($name);
		if ($set_value == $value) {
			$checked = true;
		}

		$fizzle_check = self::_fizzle($name, $value, $attributes);
		$attributes = array_pop($fizzle_check);

		return parent::radio($name, $value, $checked, $attributes);
	}

	/**
	 * Using the input class, and the field name, looks to see
	 * if a value is already present for the selected form element. If it is, it
	 * will correctly choose the right action (populate the value, check the box,
	 * select the appropriate option.etc.)
	 *
	 * @param string $field
	 */
	private static function _handle_value($field, $default)
	{
		$set_value = false;
		$possible_value = @self::$values[$field] ?: Input::get($field);

		if ($possible_value or $possible_value === 0) {
			return $possible_value;
		}
		else {
			return $default;
		}
	}

	/**
	 * Checks to see if a given element has failed validation. If it has, it
	 * will append the error class to the element's class attribute.
	 *
	 * @param string $field
	 * @param array $attributes
	 */
	private static function _check($field, $attributes)
	{
		if (!is_array($attributes)) (array) $attributes;
		
		if (self::_invalid($field))
		{
			$error_class = Config::get('fizz::fizz.fizz_error_class_name', Config::get('fizz.fizz_error_class_name'));
			$attributes['class'] = (!isset($attributes['class'])) ? $error_class : $attributes['class'].' '.$error_class;
		}
		
		return $attributes;
	}

	/**
	 * Checks to see whether a given field is invalid
	 *
	 * @param string $field
	 * @return boolean true if invalid, false otherwise
	 */
	private static function _invalid($field)
	{
		if (self::$errors) {
			// check to see if this field has a confirmation issue
			if (strpos($field, 'confirmation')) {
				$field_without_confirm = str_replace('_confirmation', '', $field);
				if (isset(self::$errors[$field_without_confirm])) {
					// the field without the confirmation has an error, so we have to assume this one does as well
					return true;
				}
			}
		
			return isset(self::$errors[$field]);
		}
	}
}
