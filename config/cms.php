<?php

return array(

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
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => array(
		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Foundation\Providers\ComposerServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Events\EventServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Foundation\Providers\PublisherServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',

		'Cms\Providers\AuthServiceProvider',
		'Cms\Providers\RoutingServiceProvider',
		'Cms\Providers\ViewServiceProvider',
		'Cms\Providers\ModuleServiceProvider',
		'Cms\Providers\SessionServiceProvider',
		'Cms\Providers\SettingsServiceProvider',
		'Cms\Providers\MenuServiceProvider',
		'Cms\Providers\ProfilerServiceProvider',
	),

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
		'Event'      => 'Illuminate\Support\Facades\Event',
		'File'       => 'Illuminate\Support\Facades\File',
		'Hash'       => 'Illuminate\Support\Facades\Hash',
		'Input'      => 'Illuminate\Support\Facades\Input',
		'Lang'       => 'Illuminate\Support\Facades\Lang',
		'Log'        => 'Illuminate\Support\Facades\Log',
		'Mail'       => 'Illuminate\Support\Facades\Mail',
		'MessageBag' => 'Illuminate\Support\MessageBag',
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

		'Plugin'     => 'Cms\Plugins\Plugin',
		'Controller' => 'Cms\Routing\Controllers\Controller',

		'HttpNotFoundException' => 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',

		'Eloquent'   => 'Cms\Database\Eloquent',
		'Autoloader' => 'Cms\Facades\Autoloader',
		'Cms'        => 'Cms\Facades\Cms',
		'Menu'       => 'Cms\Facades\Menu',
		'Modules'    => 'Cms\Facades\Modules',
		'Plugins'    => 'Cms\Facades\Plugins',
		'Settings'   => 'Cms\Facades\Settings',
		'User'       => 'Cms\Auth\Models\User',
		'Group'      => 'Cms\Auth\Models\Group',
		'Permission' => 'Cms\Auth\Models\Permission',

		'Profiler'   => 'Profiler\Facades\Profiler',
	),
);