<?php

/*
|--------------------------------------------------------------------------
| Register the User Filters
|--------------------------------------------------------------------------
|
| These filters will allow routes to check if a user is logged in, logged
| out, or an admin. They can be reused by other modules.
|
*/

Route::filter('loggedIn', function()
{
	if( ! Auth::check())
	{
		return Redirect::to('users/login');
	}
});

Route::filter('admin', function()
{
	$group = Auth::user()->group;

	if($group->name != 'admin' and $group->power < 100)
	{
		if(Auth::check())
		{
			return Redirect::to('users/profile');
		}

		else
		{
			return Redirect::to('users/login');
		}
	}
});

Route::filter('loggedOut', function()
{
	if(Auth::check())
	{
		return Redirect::to('users/profile');
	}
});

Route::filter('requirePower', function($power)
{
	if(Auth::user()->group->power < $power)
	{
		if(Auth::check())
		{
			return Redirect::to('users/profile');
		}

		else
		{
			return Redirect::to('users/login');
		}
	}
});