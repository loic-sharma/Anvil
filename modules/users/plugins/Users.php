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

	/**
	 * Get all of the user groups.
	 *
	 * @return array
	 */
	public function groups()
	{
		return Group::all();
	}
}