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
}