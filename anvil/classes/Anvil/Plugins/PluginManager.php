<?php namespace Anvil\Plugins;

use Illuminate\Container\Container;
use Illuminate\View\Environment;

class PluginManager {

	/**
	 * The container.
	 *
	 * @var Illuminate\Container\Container
	 */
	protected $container;

	/**
	 * The view manager.
	 *
	 * @var Illuminate\View\Environment
	 */
	protected $view;

	/**
	 * All of the registered plugins.
	 *
	 * @var array
	 */
	protected $plugins = array();

	/**
	 * Register the view manager.
	 *
	 * @param  Illuminate\Container\Container $container
	 * @param  Illuminate\View\Environment    $view
	 * @return void
	 */
	public function __construct(Container $container, Environment $view)
	{
		$this->container = $container;
		$this->view = $view;
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
			$class = $this->container->make($class);
		}

		// If the class inherits the Plugin class, let's wrap it around
		// in the Facade class so that attributes can managed.
		if($class instanceof Plugin)
		{
			$class = new Facade($class);
		}

		// Register the plugin in the view environment.
		$this->view->share($plugin, $class);

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
	public function get($plugin)
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