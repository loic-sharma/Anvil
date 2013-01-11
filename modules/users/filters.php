<?php

Route::addFilter('logged_in', function()
{
	if( ! Auth::check())
	{
		return Redirect::to('users/login');
	}
});

Route::addFilter('logged_out', function()
{
	if(Auth::check())
	{
		return Redirect::to('users/profile');
	}
});