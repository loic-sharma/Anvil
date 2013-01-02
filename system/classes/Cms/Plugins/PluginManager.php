<?php

namespace Cms\Plugins;

use Closure;

class PluginManager {

	/**
	 * The application instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * All of the registered plugins.
	 *
	 * @var array
	 */
	protected $plugins = array();

	/**
	 * Create a new plugin manager instance.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Register a plugin.
	 *
	 * @param  string  $plugin
	 * @param  string  $value
	 */
	public function register($plugin, $class)
	{
		if(is_string($class) and class_exists($class))
		{
			$class = $this->app->make($class);
		}

		$this->plugins[$plugin] = $class;
	}

	/**
	 * Retrieve all of the registered plugins.
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->plugins;
	}

	/**
	 * Retrieve the instance of a Plugin.
	 *
	 * @param  string  $plugin
	 * @return object
	 */
	public function __get($plugin)
	{
		return $this->plugins[$plugin];
	}
}