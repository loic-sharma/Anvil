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
			$this->plugins[$plugin] = $this->app->share(function($app) use($class)
			{
				return $app->make($class);
			});
		}
	}

	/**
	 * Retrieve all of the registered plugins.
	 *
	 * @return array
	 */
	public function all()
	{
		$plugins = array();

		foreach($this->plugins as $plugin => $value)
		{
			$plugins[$plugin] = $this->make($plugin);
		}

		return $plugins;
	}

	/**
	 * Retrieve the instance of a Plugin.
	 *
	 * @param  string  $plugin
	 * @return object
	 */
	public function make($plugin)
	{
		if(isset($this->plugins[$plugin]))
		{
			// We need to create an instance of the plugin if the value
			// is still a closure. 
			if($this->plugins[$plugin] instanceof Closure)
			{
				$this->plugins[$plugin] = $this->plugins[$plugin]($this->app);
			}

			return $this->plugins[$plugin];
		}

		else
		{
			throw new \InvalidArgumentException("Plugin [$plugin] does not exist");
		}
	}

	/**
	 * Retrieve the instance of a Plugin.
	 *
	 * @param  string  $plugin
	 * @return object
	 */
	public function __get($plugin)
	{
		return $this->make($plugin);
	}
}