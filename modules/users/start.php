<?php

Autoloader::map(array(

	'User' => __DIR__.'/models/User.php',
));

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

Route::addFilter('logged_in', function()
{
	if( ! Sentry::check())
	{
		return Redirect::to('users/login');
	}
});

Route::addFilter('logged_out', function()
{
	if(Sentry::check())
	{
		return Redirect::to('users/profile');
	}
});

Plugins::register('user', 'UserPlugin');