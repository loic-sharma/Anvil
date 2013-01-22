<?php

class UserPlugin {

	/**
	 * Check if the user is logged in.
	 *
	 * @return bool
	 */
	public function loggedIn()
	{
		return Auth::check();
	}

	/**
	 * Get a property from the current user.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return Auth::user()->key;
	}

	/**
	 * Call a method off of the current user model.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		switch (count($args))
		{
			case 0:
				return Auth::user()->$method();

			case 1:
				return Auth::user()->$method($args[0]);

			case 2:
				return Auth::user()->$method($args[0], $args[1]);

			case 3:
				return Auth::user()->$method($args[0], $args[1], $args[2]);

			case 4:
				return Auth::user()->$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array(Auth::user(), $method), $args);
		}
	}	
}