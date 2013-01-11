<?php

class UserPlugin {

	public function loggedIn()
	{
		return Auth::check();
	}

	public function displayName()
	{
		return Auth::user()->displayName();
	}
}