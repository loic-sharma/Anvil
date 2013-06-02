<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Set PHP Error Reporting Options
|--------------------------------------------------------------------------
|
| Here we will set the strictest error reporting options, and also turn
| off PHP's error reporting, since all errors will be handled by the
| framework and we don't want any output leaking back to the user.
|
*/

error_reporting(-1);

/*
|--------------------------------------------------------------------------
| Check Extensions
|--------------------------------------------------------------------------
|
| Laravel requires a few extensions to function. Here we will check the
| loaded extensions to make sure they are present. If not we'll just
| bail from here. Otherwise, Composer will crazily fall back code.
|
*/

if ( ! extension_loaded('mcrypt'))
{
	die('Laravel requires the Mcrypt PHP extension.'.PHP_EOL);

	exit(1);
}

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
| Load The Autoloader
|--------------------------------------------------------------------------
|
| Anvil relies heavily on Composer components. We'll need the autoloader
| to load those components and Anvil.
|
*/

$autoloader = include __DIR__.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Setup Patchwork UTF-8 Handling
|--------------------------------------------------------------------------
|
| The Patchwork library provides solid handling of UTF-8 strings as well
| as provides replacements for all mb_* and iconv type functions that
| are not available by default in PHP. We'll setup this stuff here.
|
*/

Patchwork\Utf8\Bootup::initMbstring();

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
use Illuminate\Foundation\AliasLoader;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\ProviderRepository;

use Anvil\Routing\Inspector\BasicInspector;
use Anvil\Routing\Inspector\AdminInspector;

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

$anvil->redirectIfTrailingSlash();

/*
|--------------------------------------------------------------------------
| Bind The Application In The Container
|--------------------------------------------------------------------------
|
| This may look strange, but we actually want to bind the app into itself
| in case we need to Facade test an application. This will allow us to
| resolve the "app" key out of this container for this app's facade.
|
*/

$anvil->instance('app', $anvil);

/*
|--------------------------------------------------------------------------
| Register The Autoloader
|--------------------------------------------------------------------------
|
| Inject the composer autoloader into the app.
|
*/

$anvil->instance('autoloader', $autoloader);

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
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Illuminate takes a dead simple approach to application environments.
| Just specify the hosts that belong to a given environment, and we
| will quickly detect and set the application environment for you.
|
*/

$env = $anvil->detectEnvironment(array());

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

$config = new Config($anvil->getConfigLoader(), $env);

$anvil->instance('config', $config);

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

$aliases = $config['anvil']['aliases'];

AliasLoader::getInstance($aliases)->register();

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

$providers = $config['anvil']['providers'];

$anvil->getProviderRepository()->load($anvil, $providers);

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

$anvil->redirectIfUninstalled($config);

/*
|--------------------------------------------------------------------------
| Register The Anvil Request Inspectors
|--------------------------------------------------------------------------
|
| Anvil matches a request to controllers through its inspectors. The
| detected routes can be overriden by simply registering custom routes.
| Additionally, modules can register their own inspectors to modify how
| requests are handled.
|
*/

Inspector::addInspector(new BasicInspector);
Inspector::addInspector(new AdminInspector);

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

Plugins::register('url', $anvil['url.plugin']);
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

Modules::boot();

/*
|--------------------------------------------------------------------------
| Load the CMS's filters.
|--------------------------------------------------------------------------
|
| The filters manage the user's access to sensitive routes. For example,
| They ensure that regular users do not attempt to access the Admin panel.
|
*/

include __DIR__.'/filters.php';

/*
|--------------------------------------------------------------------------
| Start Anvil
|--------------------------------------------------------------------------
|
| Each action corresponds, by default, to a module and a controller.
| Anvil will attempt to register a default route for each request, even
| though a module might have already registered a route. Let's set the
| default the route now and then start Laravel.
|
*/

$anvil->start($anvil['request'], $anvil['routing.inspector'], $anvil['router']);

/*
|--------------------------------------------------------------------------
| Set The Current Theme
|--------------------------------------------------------------------------
|
| All of the design elements for the current page are stored in the theme.
| Let's register the current theme now. Note that the admin panel has its
| own unique theme, whereas the rest of the site just uses the theme
| in the settings.
|
*/

$theme = $anvil->isAdmin() ? 'admin' : Settings::get('theme');

Themes::start($theme);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $anvil;