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
}