<?php

/*
|--------------------------------------------------------------------------
| Define The Laravel Version
|--------------------------------------------------------------------------
|
| Here we will set the Laravel version that is utilized to identify this
| installation of the framework. It is primarily used via the console
| to display the version to the developer for information purposes.
|
*/

if ( ! defined('LARAVEL_VERSION'))
{
	define('LARAVEL_VERSION', '4.0.0');
}

/*
|--------------------------------------------------------------------------
| Register Class Imports
|--------------------------------------------------------------------------
|
| Here we will just import a few classes that we need during the booting
| of the framework. These are mainly classes that involve loading the
| config files for this application, such as the config repository.
|
*/
use Illuminate\Http\Request;
use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\ProviderRepository;

use Anvil\Plugins\UrlPlugin;

/*
|--------------------------------------------------------------------------
| Load The Autoloader
|--------------------------------------------------------------------------
|
| The CMS relies heavily on Composer components. We'll need the autoloader
| to load those components, and then to load the CMS itself.
|
*/

$autoloader = include __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Create The CMS
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of the CMS, and is
| the IoC container for the system binding all of the various parts.
|
*/

$anvil = new Anvil\Application;

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

$anvil->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| Register The Autoloader
|--------------------------------------------------------------------------
|
| Inject the autoloader into the app.
|
*/

$anvil->bind('autoloader', function() use($autoloader)
{
	return $autoloader;
});

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

$env = $anvil->detectEnvironment(array(

	'local' => array('your-machine-name'),

));

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

Facade::setFacadeApplication($anvil);

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

$anvil->bindIf('config.loader', function($anvil)
{
	return new FileLoader(new Filesystem, $anvil['path.base'].'config');

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

$anvil->startExceptionHandling();

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

$config = new Config($anvil['config.loader'], $env);

$anvil->instance('config', $config);

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

$anvil->registerAliasLoader($config['cms']['aliases']);

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

$services = new ProviderRepository(new Filesystem, $config['cms']['manifest']);

$services->load($anvil, $config['cms']['providers']);

/*
|--------------------------------------------------------------------------
| Boot The Application
|--------------------------------------------------------------------------
|
| Before we handle the requests we need to make sure the application has
| been booted up. The boot process will call the "boot" method on all
| service provider giving all a chance to register their overrides.
|
*/

$anvil->boot();

/*
|--------------------------------------------------------------------------
| Install the CMS
|--------------------------------------------------------------------------
|
| The installation process creates a database configuration file. If it
| doesn't exist then Anvil has not been installed yet. We'll redirect the
| user here so that Anvil can be set up.
|
*/

if(empty($config['database']))
{
	header('Location: '.$anvil['url']->base().'installer/');

	exit;
}

/*
|--------------------------------------------------------------------------
| Boot the User's Session
|--------------------------------------------------------------------------
|
| By default, Laravel boots the session in the route's before filter.
| However, we want the plugins and modules to have access to the session
| data so we will start the session in advance. 
|
*/

Session::start($anvil['cookie'], $config['session.cookie']);

/*
|--------------------------------------------------------------------------
| Register Plugins
|--------------------------------------------------------------------------
|
| Plugins are classes that are directly injected into view. Load the
| core plugins nows.
|
*/

Plugins::register('url', new UrlPlugin($anvil['request'], $anvil['url']));

Plugins::register('navigation', $anvil['menu.plugin']);

/*
|--------------------------------------------------------------------------
| Load The CMS Modules
|--------------------------------------------------------------------------
|
| Allow the modules to bootstrap their code. This happens before the CMS
| attempts to detect the default route so that module's routes have
| precedence over the CMS's.
|
*/

foreach(Modules::get() as $module => $details)
{
	Modules::boot($module);
}

/*
|--------------------------------------------------------------------------
| Load the CMS's filters.
|--------------------------------------------------------------------------
|
| The filters manage the user's access to sensitive routes.
|
*/

include __DIR__.'/filters.php';

/*
|--------------------------------------------------------------------------
| Start The CMS
|--------------------------------------------------------------------------
|
| Each action corresponds, by default, to a module and a controller.
| Although a module may have already registered a route that matches the
| request, the CMS will still register a default route. Note that any
| routes registered after the default route will be ignored.
|
*/

$anvil->start($anvil['request'], $anvil['settings'], $anvil['router']);