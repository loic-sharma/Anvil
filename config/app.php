<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => true,

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => 'UTC',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locales' => array('en'),

	'locale' => 'en',

	'fallback_locale' => 'en',

	'locale_path' => __DIR__.'/../cms/lang',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, long string, otherwise these encrypted values will not
	| be safe. Make sure to change it before deploying any application!
	|
	*/

	'key' => 'YourSecretKey!!!',

	/*
	|--------------------------------------------------------------------------
	| Service Provider Manifest
	|--------------------------------------------------------------------------
	|
	| The service provider manifest is used by Laravel to lazy load service
	| providers which are not needed for each request, as well to keep a
	| list of all of the services. Here, you may set its storage spot.
	|
	*/

	'manifest' => __DIR__.'/../cms/storage/meta',

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => array(

		'App'        => 'Illuminate\Support\Facades\App',
		'Artisan'    => 'Illuminate\Support\Facades\Artisan',
		'Auth'       => 'Illuminate\Support\Facades\Auth',
		'Cache'      => 'Illuminate\Support\Facades\Cache',
		'Config'     => 'Illuminate\Support\Facades\Config',
		'Cookie'     => 'Illuminate\Support\Facades\Cookie',
		'Crypt'      => 'Illuminate\Support\Facades\Crypt',
		'DB'         => 'Illuminate\Support\Facades\DB',
		'Eloquent'   => 'Illuminate\Database\Eloquent\Model',
		'Event'      => 'Illuminate\Support\Facades\Event',
		'File'       => 'Illuminate\Support\Facades\File',
		'Hash'       => 'Illuminate\Support\Facades\Hash',
		'Input'      => 'Illuminate\Support\Facades\Input',
		'Lang'       => 'Illuminate\Support\Facades\Lang',
		'Log'        => 'Illuminate\Support\Facades\Log',
		'Mail'       => 'Illuminate\Support\Facades\Mail',
		'Paginator'  => 'Illuminate\Support\Facades\Paginator',
		'Redirect'   => 'Illuminate\Support\Facades\Redirect',
		'Redis'      => 'Illuminate\Support\Facades\Redis',
		'Request'    => 'Illuminate\Support\Facades\Request',
		'Response'   => 'Illuminate\Support\Facades\Response',
		'Route'      => 'Illuminate\Support\Facades\Route',
		'Schema'     => 'Illuminate\Support\Facades\Schema',
		'Session'    => 'Illuminate\Support\Facades\Session',
		'URL'        => 'Illuminate\Support\Facades\URL',
		'Validator'  => 'Illuminate\Support\Facades\Validator',
		'View'       => 'Illuminate\Support\Facades\View',

		'HTML'       => 'Meido\HTML\Facades\HTML',
		'Form'       => 'Meido\Form\Facades\Form',

		'Plugin'     => 'Cms\Plugins\Plugin',
		'Controller' => 'Cms\Routing\Controllers\Controller',

		'HttpNotFoundException' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',

		'Autoloader' => 'Cms\Facades\Autoloader',
		'Menu'       => 'Cms\Facades\Menu',
		'Modules'    => 'Cms\Facades\Modules',
		'Plugins'    => 'Cms\Facades\Plugins',
		'Settings'   => 'Cms\Facades\Settings',
		'User'       => 'Cms\Auth\Models\User',

//		'Sentry'     => 'Cms\Facades\Sentry',
	),
);
