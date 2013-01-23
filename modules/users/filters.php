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

Route::filter('logged_in', function()
{
	if( ! Auth::check())
	{
		return Redirect::to('users/login');
	}
});

Route::filter('admin', function()
{
	if(Auth::check())
	{
		$group = Auth::user()->group;

		if($group->name == 'admin' or $group->power >= 100)
		{
			return true;
		}
	}

	return false;
});

Route::filter('logged_out', function()
{
	if(Auth::check())
	{
		return Redirect::to('users/profile');
	}
});


/*
|--------------------------------------------------------------------------
| Load The Autoloader
|--------------------------------------------------------------------------
|
| The CMS relies heavily on Composer components. We'll need the autoloader
| to load those components, and then to load the CMS itself.
|
*/
Route::filter('admin/*', 'admin');