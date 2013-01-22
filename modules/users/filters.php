<?php

Route::addFilter('logged_in', function()
{
	if( ! Auth::check())
	{
		return Redirect::to('users/login');
	}
});

Route::addFilter('admin', function()
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

Route::addFilter('logged_out', function()
{
	if(Auth::check())
	{
		return Redirect::to('users/profile');
	}
});