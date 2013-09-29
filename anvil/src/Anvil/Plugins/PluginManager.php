<?php namespace Anvil\Plugins;

use Anvil\Application;
use Illuminate\View\Environment;

class PluginManager {

	/**
	 * The container.
	 *
	 * @var Anvil\Application
	 */
	protected $anvil;

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
	 * @param  Anvil\Application              $anvil
	 * @param  Illuminate\View\Environment    $view
	 * @return void
	 */
	public function __construct(Application $anvil, Environment $view)
	{
		$this->anvil = $anvil;
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
		// Build an instance of the plugin.
		if(is_string($plugin))
		{
			$plugin = $this->anvil->make($plugin);
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