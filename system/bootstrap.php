<?php

use Illuminate\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Config\FileLoader;
use Illuminate\Support\Facades\Facade;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\ProviderRepository;

/*
|--------------------------------------------------------------------------
| Load the Autoloader
|--------------------------------------------------------------------------
|
| The CMS relies heavily on Composer components. We'll need the autoloader
| to load those components, and then to load the CMS itself.
|
*/

$autoloader = include 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Define The Application Path
|--------------------------------------------------------------------------
|
| Here we just defined the path to the application directory. Most likely
| you will never need to change this value, as the default setup should
| work perfectly fine for the vast majority of all application setups.
|
*/

$app->instance('path', __DIR__);
$app->instance('path.base', dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Register The Autoloader
|--------------------------------------------------------------------------
|
| Inject the autoloader into the app and register the base Cms
| class path.
|
*/

$app->bind('autoloader', function($app) use($autoloader)
{
	return $autoloader;
});

$autoloader->add('Cms', $app->path.'/classes');

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Illuminate takes a dead simple approach to application environments.
| Just specify the hosts that belong to a given environment, and we
| will quickly detect and set the application environment for you.
|
*/

$app->detectEnvironment(array(

	'local' => array('localhost', '*.dev', '*.app'),

));

$env = 'development';

/*
|--------------------------------------------------------------------------
| Load The Illuminate Facades
|--------------------------------------------------------------------------
|
| The facades provide a terser static interface over the various parts
| of the application, allowing their methods to be accessed through
| a mixtures of magic methods and facade derivatives. It's slick.
|
*/

Facade::clearResolvedInstances();

Facade::setFacadeApplication($app);

/*
|--------------------------------------------------------------------------
| Register The Configuration Loader
|--------------------------------------------------------------------------
|
| The configuration loader is responsible for loading the configuration
| options for the application. By default we'll use the "file" loader
| but you are free to use any custom loaders with your application.
|
*/

$app->bindIf('config.loader', function($app)
{
	return new FileLoader(new Filesystem, $app['path'].'/config');

}, true);

/*
|--------------------------------------------------------------------------
| Register Application Exception Handling
|--------------------------------------------------------------------------
|
| We will go ahead and register the application exception handling here
| which will provide a great output of exception details and a stack
| trace in the case of exceptions while an application is running.
|
*/

// $app->startExceptionHandling();

/*
|--------------------------------------------------------------------------
| Register The Configuration Repository
|--------------------------------------------------------------------------
|
| The configuration repository is used to lazily load in the options for
| this application from the configuration files. The files are easily
| separated by their concerns so they do not become really crowded.
|
*/

$config = new Config($app['config.loader'], $env);

$app->instance('config', $config);

/*
|--------------------------------------------------------------------------
| Set The Default Timezone
|--------------------------------------------------------------------------
|
| Here we will set the default timezone for PHP. PHP is notoriously mean
| if the timezone is not explicitly set. This will be used by each of
| the PHP date and date-time functions throoughout the application.
|
*/

date_default_timezone_set($config['app']['timezone']);

/*
|--------------------------------------------------------------------------
| Register The Alias Loader
|--------------------------------------------------------------------------
|
| The alias loader is responsible for lazy loading the class aliases setup
| for the application. We will only register it if the "config" service
| is bound in the application since it contains the alias definitions.
|
*/

$app->registerAliasLoader($config['app']['aliases']);

/*
|--------------------------------------------------------------------------
| Enable HTTP Method Override
|--------------------------------------------------------------------------
|
| Next we will tell the request class to allow HTTP method overriding
| since we use this to simulate PUT and DELETE requests from forms
| as they are not currently supported by plain HTML form setups.
|
*/

Request::enableHttpMethodParameterOverride();

/*
|--------------------------------------------------------------------------
| Register The Core Service Providers
|--------------------------------------------------------------------------
|
| The Illuminate core service providers register all of the core pieces
| of the Illuminate framework including session, caching, encryption
| and more. It's simply a convenient wrapper for the registration.
|
*/

$services = new ProviderRepository(new Filesystem);

$services->load($app, $config['providers']);

/*
|--------------------------------------------------------------------------
| Load the CMS Modules
|--------------------------------------------------------------------------
|
|
*/

foreach($app->modules->get() as $module => $details)
{
	$app->modules->boot($module);
}

/*
|--------------------------------------------------------------------------
| Register Plugins
|--------------------------------------------------------------------------
|
| Plugins are classes that are directly injected into templates. Load the
| default plugins nows.
|
*/

Plugins::register('url', 'Cms\Plugins\UrlPlugin');
Plugins::register('session', 'Cms\Plugins\SessionPlugin');

/*
|--------------------------------------------------------------------------
| Register the Default Route
|--------------------------------------------------------------------------
|
| Each action corresponds, by default, to a module and a controller.
| Although a module may have already registered a route that matches the
| request, this will be serve as a back up route.
|
*/

$app['controller.router']->setDefaultRoute();
