<?php

Route::get('/', function()
{
	$errors = array();

	// Check requirements.
	$base = dirname(dirname(__FILE__));

	$paths = array(
		$base . '/anvil/storage/cache/',
		$base . '/anvil/storage/logs/',
		$base . '/anvil/storage/meta/',
		$base . '/anvil/storage/sessions/',
		$base . '/anvil/storage/views/',
	);

	foreach($paths as $path)
	{
		if( ! is_writable($path))
		{
			$errors[] = $path . ' must be writable.';
		}
	}

	return View::make('requirements', compact('errors'));
});

Route::get('step-2', function()
{
	return View::make('database');
});

Route::post('step-2', function()
{
	$form = Validator::make($input = Input::all(), array(
		'hostname' => array('required'),
		'username' => array('required'),
		'password' => array('required'),
		'database' => array('required'),
	));

	if($form->passes())
	{
		$search = array_map(function($key)
		{
			return '{{'.$key.'}}';

		}, array_keys($input));

		$replace = array_values($input);

		$stub = File::get(__DIR__.'/stubs/database.php');

		$stub = str_replace($search, $replace, $stub);

		File::put(__DIR__.'/../config/database.php', $stub);

		return Redirect::to('step-3');
	}

	else
	{
		return Redirect::to('step-2')->withErrors($form);
	}
});

Route::get('step-3', function()
{
	echo 'Step 3';
});