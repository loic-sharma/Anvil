<?php namespace Cms\Plugins;

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
	 * @param  mixed  $plugin
	 * @param  string  $value
	 */
	public function register($plugin, $class)
	{
		// If we were given a string, let's get an instance of the plugin.
		if(is_string($class) and class_exists($class))
		{
			$class = $this->app->make($class);
		}

		// If the class inherits the Plugin class, let's wrap it around
		// in the Facade class so that attributes can managed.
		if($class instanceof Plugin)
		{
			$class = new Facade($class);
		}

		// Register the plugin in the view environment.
		$this->app['view']->share($plugin, $class);

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
	public function get()
	{
		return $this->plugins[$plugin];
	}

	/**
	 * Retrieve the instance of a Plugin.
	 *
	 * @param  string  $plugin
	 * @return object
	 */
	public function __get($plugin)
	{
		return $this->get($plugin);
	}
}