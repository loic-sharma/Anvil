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
	$files = Anvil::make('files');

	// Build Anvil's tables.
	$migrations = $files->glob(__DIR__.'/database/migrations/*.php');

	foreach($migrations as $migration)
	{
		include $migration;
	}

	// Now seed the tables with the default content.
	$path = __DIR__.'/database/seeds/';

	$seeds = $files->glob(__DIR__.'/database/seeds/*.php');

	foreach($seeds as $seed)
	{
		$table = str_replace(array($path, '.php'), '', $seed);

		$seed = include $seed;

		DB::table($table)->insert($seed);
	}

	return Redirect::to('step-4');
});

Route::get('step-4', function()
{
	return View::make('create_admin');
});

Route::post('step-4', function()
{
	$form = Validator::make(Input::all(), array(
		'email'    => array('required', 'email'),
		'password' => array('required', 'confirmed'),
	));

	if($form->passes())
	{
		$id = DB::table('users')->insertGetId(array(
			'group_id' => 4,
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password')),
			'first_name' => 'John',
			'last_name' => 'Doe',
		));

		Auth::loginUsingId($id);

		return Redirect::to('/../../');	
	}

	return Redirect::to('step-4')->withErrors($form);
});