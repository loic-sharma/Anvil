<?php

/*
 |--------------------------------------------------------------------------
 | Logged in Authentication Filter
 |--------------------------------------------------------------------------
 |
 | Verify that the current user is logged in.
 |
 */

Route::filter('loggedIn', function()
{
	if( ! Auth::check())
	{
		return Redirect::to('users/login');
	}
});

/*
 |--------------------------------------------------------------------------
 | Logged Out Authentication Filter
 |--------------------------------------------------------------------------
 |
 | Verify that the current user is logged out.
 |
 */

Route::filter('loggedOut', function()
{
	if(Auth::check())
	{
		return Redirect::to('users/profile');
	}
});

/*
 |--------------------------------------------------------------------------
 | Permission Authentication Filter
 |--------------------------------------------------------------------------
 |
 | Verify that the current user has a certain permission.
 |
 */

Route::filter('can', function($permission)
{
	if(Auth::user()->can($permission))
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

/*
 |--------------------------------------------------------------------------
 | Power Authentication Filter
 |--------------------------------------------------------------------------
 |
 | Verify that the current user's power is less than a certain integer.
 |
 */

Route::filter('maxPower', function($power)
{
	if(Auth::user()->group->power >= $power)
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

/*
 |--------------------------------------------------------------------------
 | Power Authentication Filter.
 |--------------------------------------------------------------------------
 |
 | Verify that the current user's power is greater than a certain integer.
 |
 */

Route::filter('requirePower', function($power)
{
	if(Auth::user()->group->power <= $power)
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

/*
 |--------------------------------------------------------------------------
 | Group Authentication Filter
 |--------------------------------------------------------------------------
 |
 | Require the current user to belong to a certain group.
 |
 */

Route::filter('is', function($group)
{
	if(Auth::user()->is($group))
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

/*
 |--------------------------------------------------------------------------
 | Admin Authentication Filter
 |--------------------------------------------------------------------------
 |
 | Verify that the current user can access the admin panel.
 |
 */

Route::filter('admin', function()
{
	if(Auth::user()->cannot('access_admin_panel'))
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}

		else
		{
			return Redirect::to('users/login');
		}
	}
});

/*
 |--------------------------------------------------------------------------
 | Register Admin Filters
 |--------------------------------------------------------------------------
 |
 | Prevent users from accessing routes that they do not have permission for.
 |
 */

Route::when('admin', 'admin');
Route::when('admin/*', 'admin');

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});