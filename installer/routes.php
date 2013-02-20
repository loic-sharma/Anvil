<?php

Route::get('/', function()
{
	$error = false;

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
			$errors = true;

			echo '<p>'.$path . ' must be writable.</p>';
		}
	}

	if($errors == false)
	{
		echo '<p><a href="'.URL::to('step-2').'">Next step</a></p>';
	}
});

Route::get('step-2', function()
{
	echo 'Second step.';
});