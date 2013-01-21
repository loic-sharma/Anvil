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
	 * Get the user's login name.
	 *
	 * @return string
	 */
	public function displayName()
	{
		return Auth::user()->displayName();
	}

	/**
	 * Get a user's permissions.
	 *
	 * @return bool
	 */
	public function can($permission)
	{
		return Auth::user()->can($permission);
	}
}