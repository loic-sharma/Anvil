<?php

namespace Cms\Facades;

use Illuminate\Support\Facades\Facade;

class Autoloader extends Facade {

	/**
	 * Add a directory to the autoloader.
	 *
	 * @param  string  $directory
	 * @return void
	 */
	public static function directory($directory)
	{
		static::directories($directory);
	}

	/**
	 * Add directories to the autoloader.
	 *
	 * @param  array  $directories
	 * @return void
	 */
	public static function directories($directories)
	{
		static::$app['autoloader']->add(null, (array) $directories);
	}

	/**
	 * Register fully-namespaced classes to the autoloader.
	 *
	 * @param  array  $classes
	 * @return void
	 */
	public static function map(array $classes)
	{
		static::$app['autoloader']->addClassMap($classes);
	}

	/**
	 * Register namespaces to the autoloader.
	 *
	 * @param  array  $namespaces
	 * @return void
	 */
	public static function namespaces(array $namespaces)
	{
		foreach($namespaces as $namespace => $directories)
		{
			static::$app['autoloader']->add($namespace, $directories);
		}
	}

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'autoloader'; }
}