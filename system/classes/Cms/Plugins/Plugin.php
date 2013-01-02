<?php

namespace Cms\Plugins;

abstract class Plugin {

	/**
	 * The application instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected static $app;

	/**
	 * Set the application instance.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @return void
	 */
	public static function setApplication($app)
	{
		static::$app = $app;
	}

	/**
	 * Get the value of an attribute.
	 *
	 * @param  array   $options
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function attribute(array $options = null, $key = null, $default = null)
	{
		if(isset($options[$key]))
		{
			return $options[$key];
		}

		else
		{
			return $default;
		}
	}
}