<?php

Autoloader::map(array(

	'User' => __DIR__.'/models/User.php',
));

class UserPlugin {

	public function loggedIn()
	{
		return Sentry::check();
	}

	public function has_cp_permissions()
	{
		
	}
}

Plugins::register('user', 'UserPlugin');

app()->view->share('auth', app()->auth);