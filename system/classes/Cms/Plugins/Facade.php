<?php

namespace Cms\Plugins;

use Illuminate\View\Environment as ViewEnvironment;

class Facade {

	/**
	 * The plugin.
	 *
	 * @var Plugin\Plugin
	 */
	protected $plugin;

	/**
	 * The instance of the reflection class, used to determine
	 * what parameters the plugin requires.
	 *
	 * @var ReflectionClass
	 */
	protected $reflector = null;

	/**
	 * Register the plugin.
	 *
	 * @param  Plugin\Plugin  $plugin
	 * @return void
	 */
	public function __construct(Plugin $plugin)
	{
		$this->plugin = $plugin;
	}

	/**
	 * Retrieve public class variable from the plugin.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->plugin->$key;
	}

	/**
	 * Set a public class variable to the plugin.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->plugin->$key = $value;
	}

	/**
	 * Call one of the plugin's methods.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		// If only an array was passed to the method, then we will
		// assume that the array contains attributes.
		if(count($args) == 1 && is_array($args[0]))
		{
			$this->plugin->setAttributes($args[0]);

			// If the plugin's corresponding method has more than one parameter,
			// we will assume that the plugin wants the attributes mapped directly
			// to it's parameters.
			$parameters = $this->getParameters($method);

			if(count($parameters) >= 1)
			{
				$params = array();
				$inputKeys = array_keys($args[0]);

				// Let's check each of the method's parameters to see if
				// an attribute's name matches. If so, we will use
				// its value for the parameter.
				foreach($parameters as $parameter)
				{
					if(in_array($parameter->name, $inputKeys))
					{
						$params[] = $args[0][$parameter->name];
					}

					else
					{
						// If no attributes match, we will use the parameter's default
						// value, if it has one.
						if($parameter->isDefaultValueAvailable())
						{
							$params[] = $parameter->getDefaultValue();
						}

						// If the parameter doesn't have a default value, we'll just input
						// null.
						else
						{
							$params[] = null;
						}
					}
				}

				return call_user_func_array(array($this->plugin, $method), $params);
			}
		}

		switch (count($args))
		{
			case 0:
				return $this->plugin->$method();

			case 1:
				return $this->plugin->$method($args[0]);

			case 2:
				return $this->plugin->$method($args[0], $args[1]);

			case 3:
				return $this->plugin->$method($args[0], $args[1], $args[2]);

			case 4:
				return $this->plugin->$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array($this->plugin, $method), $args);
		}
	}

	protected function reflector()
	{
		if(is_null($this->reflector))
		{
			$this->reflector = new \ReflectionClass($this->plugin);
		}

		return $this->reflector;
	}

	protected function getParameters($method)
	{
		return $this->reflector()->getMethod($method)->getParameters();
	}
}