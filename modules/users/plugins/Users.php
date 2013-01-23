<?php

class UsersPlugin {

	/**
	 * Get all of the registered users.
	 *
	 * @return array
	 */
	public function get()
	{
		return User::all();
	}

	public function __call($method, $args)
	{
		switch (count($args))
		{
			case 0:
				return User::$method();

			case 1:
				return User::$method($args[0]);

			case 2:
				return User::$method($args[0], $args[1]);

			case 3:
				return User::$method($args[0], $args[1], $args[2]);

			case 4:
				return User::$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array('User', $method, $method), $args);
		}
	}
}