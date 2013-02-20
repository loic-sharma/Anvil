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
			$errors[] = '<p>'.$path . ' must be writable.</p>';
		}
	}

	return View::make('requirements', compact('errors'));
});

Route::get('step-2', function()
{
	echo 'Second step.';
});