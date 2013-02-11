<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Load Anvil
|--------------------------------------------------------------------------
|
| We need to load Anvil. This includes the vendor components that Anvil
| depends on, as well as the modules that run on ANvil.
|
*/

include 'anvil/start.php';

/*
|--------------------------------------------------------------------------
| Run Anvil
|--------------------------------------------------------------------------
|
| Now that everything is set up, let's run the request.
|
*/

$anvil->run();