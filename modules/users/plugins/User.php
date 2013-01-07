<?php

class UserPlugin {

	public function loggedIn()
	{
		return Sentry::check();
	}

	public function displayName()
	{
		$user = Sentry::getUser();

		return $user->first_name . ' ' . $user->last_name;
	}
}