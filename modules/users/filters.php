<?php

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