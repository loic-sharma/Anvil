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
	 * @param  mixed  $name
	 * @param  mixed  $value
	 * @return void
	 */
	public function register($name, $plugin)
	{
		$plugin = $this->preparePlugin($plugin);

		// Register the plugin to the view environment.
		$this->view->share($name, $plugin);

		$this->plugins[$name] = $plugin;
	}

	/**
	 * Prepare the instance of the plugin.
	 *
	 * @param  mixed  $plugin
	 * @return void
	 */
	protected function preparePlugin($plugin)
	{
		// If the plugin is currently a string, we will need to build an
		// instance. We'll use Laravel's container to automatically
		// Build an instance of the plugin.If we were given a string, let's get an instance of the plugin.
		if(is_string($plugin))
		{
			$plugin = $this->container->make($plugin);
		}

		// If the class inherits the Plugin class, let's wrap it around
		// in the Facade class so that attributes can managed.
		if($plugin instanceof Plugin)
		{
			$plugin = new Facade($plugin);
		}

		return $plugin;
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