<?php

/*
|--------------------------------------------------------------------------
| Load Anvil
|--------------------------------------------------------------------------
|
| We need to load Anvil. This includes the vendor components that Anvil
| depends on, as well as the modules that run on ANvil.
|
*/

$anvil = include 'anvil/start.php';

/*
|--------------------------------------------------------------------------
| Run Anvil
|--------------------------------------------------------------------------
|
| Now that everything is set up, let's run the request.
|
*/

$anvil->run();

/*
|--------------------------------------------------------------------------
| Shutdown The Application
|--------------------------------------------------------------------------
|
| Once the app has finished running. We will fire off the shutdown events
| so that any final work may be done by the application before we shut
| down the process. This is the last thing to happen to the request.
|
*/

$anvil->shutdown();