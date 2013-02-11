<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Load the CMS
|--------------------------------------------------------------------------
|
| We need to load the CMS. This includes the vendor components that the CMS
| depends on, as well as the modules that run on the CMS.
|
*/

include 'cms/start.php';

/*
|--------------------------------------------------------------------------
| Run The CMS
|--------------------------------------------------------------------------
|
| Now that everything is set up, let's run the request.
|
*/

$cms->run();