<?php namespace Anvil\Plugins;

use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

abstract class Plugin {

	/**
	 * The application instance.
	 *
	 * @var Anvil\Application
	 */
	protected static $anvil;

	/**
	 * The plugin's model.
	 *
	 * @var Illuminate\Database\Eloquent\Model|string
	 */
	public $model;

	/**
	 * The current plugin call's attributes.
	 *
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * Set the application instance.
	 *
	 * @param  Anvil\Application  $anvil
	 * @return void
	 */
	public static function setApplication(Application $anvil)
	{
		static::$anvil = $anvil;
	}

	/**
	 * Reset the plugin's attributes.
	 *
	 * @return void
	 */
	public function resetAttributes()
	{
		$this->attributes = array();
	}

	/**
	 * Set the plugin's attributes.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function setAttributes(array $attributes)
	{
		$this->attributes = $attributes;
	}

	/**
	 * Get the value of an attribute.
	 *
	 * @param  array   $options
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function attribute($key = null, $default = null)
	{
		if(isset($this->attributes[$key]))
		{
			return $this->attributes[$key];
		}

		else
		{
			return $default;
		}
	}

	/**
	 * Redirect a method call to the plugin's method.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		if( ! is_null($this->model))
		{
			// Fetch an instance of the model.
			if(is_object($this->model))
			{
				$model = $this->model;
			}

			else
			{
				$model = new $this->model;
			}

			// If this is an Eloquent model we'll need to fetch
			// a new query to work with.
			if($model instanceof Model)
			{
				$model = $model->newQuery();
			}

			switch (count($args))
			{
				case 0:
					return $model->$method();

				case 1:
					return $model->$method($args[0]);

				case 2:
					return $model->$method($args[0], $args[1]);

				case 3:
					return $model->$method($args[0], $args[1], $args[2]);

				case 4:
					return $model->$method($args[0], $args[1], $args[2], $args[3]);

				default:
					return call_user_func_array(array($model, $method), $args);
			}
		}

		else
		{
			// The plugin has no model, throw an exception.
			throw new \Exception("Call to undefined method [$method].");
		}
	}
}