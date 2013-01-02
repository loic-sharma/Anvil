<?php

// --------------------------------------------------------------
// Start the timer.
// --------------------------------------------------------------

define('CMS_START', microtime(true));

// --------------------------------------------------------------
// Load the system.
// --------------------------------------------------------------

include 'system/bootstrap.php';

// --------------------------------------------------------------
// Run the application.
// --------------------------------------------------------------

try
{
	$app->run();
}

catch(ReflectionException $e)
{
	if($e->getMessage() == $app['controller.router']->exceptionMessage())
	{
		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	}

	else
	{
		throw new ReflectionException($e->getMessage());
	}
}