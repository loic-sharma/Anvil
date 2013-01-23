<?php

/*
 *--------------------------------------------------------------------------
 * Logged in authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user is logged in.
 *
 */
Route::filter('loggedIn', function()
{
	if( ! Auth::check())
	{
		return Redirect::to('users/login');
	}
});

/*
 *--------------------------------------------------------------------------
 * Logged out authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user is logged out.
 *
 */
Route::filter('loggedOut', function()
{
	if(Auth::check())
	{
		return Redirect::to('users/profile');
	}
});

/*
 *--------------------------------------------------------------------------
 * Permission authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user has a certain permission.
 *
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
 *--------------------------------------------------------------------------
 * Power authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user's power is less than a certain integer.
 *
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
 *--------------------------------------------------------------------------
 * Power authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user's power is greater than a certain integer.
 *
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
 *--------------------------------------------------------------------------
 * Group authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user's power is greater than a certain integer.
 *
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
 *--------------------------------------------------------------------------
 * Group authentication filter.
 *--------------------------------------------------------------------------
 *
 * Require the current user to belong to a certain group.
 *
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
 *--------------------------------------------------------------------------
 * Admin authentication filter.
 *--------------------------------------------------------------------------
 *
 * Verify that the current user is an admin.
 *
 */
Route::filter('admin', function()
{
	$group = Auth::user()->group;

	if($group->power < 100)
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