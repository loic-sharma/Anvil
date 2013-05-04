<?php

use Illuminate\Http\Request;
use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Load The Autoloader
|--------------------------------------------------------------------------
|
| The CMS relies heavily on Composer components. We'll need the autoloader
| to load those components, and then to load the CMS itself.
|
*/

$autoloader = require_once __DIR__.'/../anvil/vendor/autoload.php';

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

$anvil->instance('path', dirname(__DIR__).'/anvil');
$anvil->instance('path.base', dirname(__DIR__));
$anvil->instance('path.storage', dirname(__DIR__).'/anvil/storage');

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

$anvil->bindIf('config.loader', function($anvil)
{
	return new FileLoader(new Filesystem, $anvil['path.base'].'/config');

}, true);

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

$config = new Config($anvil['config.loader'], null);

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

$aliases = $config['aliases'];

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
| Register The View Path
|--------------------------------------------------------------------------
|
| The installer uses a special view path. Set that here.
|
*/

$config['view.paths'] = array(__DIR__.'/views/');

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

$providers = array(
	'Illuminate\Auth\AuthServiceProvider',
	'Illuminate\Cookie\CookieServiceProvider',
	'Illuminate\Routing\ControllerServiceProvider',
	'Illuminate\Database\DatabaseServiceProvider',
	'Illuminate\Filesystem\FilesystemServiceProvider',
	'Illuminate\Hashing\HashServiceProvider',	
	'Illuminate\Encryption\EncryptionServiceProvider',
	'Illuminate\Session\SessionServiceProvider',
	'Illuminate\Translation\TranslationServiceProvider',
	'Illuminate\Validation\ValidationServiceProvider',
	'Illuminate\View\ViewServiceProvider',
);

foreach($providers as $provider)
{
	$anvil->register(new $provider($anvil));
}

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
| Load the Installation routes.
|--------------------------------------------------------------------------
|
| The installer stores all of its routes in the routes file. Let's boot
| that up now that everything else is already loaded.
|
*/

include __DIR__.'/routes.php';

/*
|--------------------------------------------------------------------------
| Run the Installer.
|--------------------------------------------------------------------------
|
| Everything is set up. Let's run the installer!
|
*/

$anvil->run();