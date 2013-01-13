<?php namespace Cms\Plugins;

abstract class Plugin {

	/**
	 * The application instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected static $app;

	/**
	 * The attributes.
	 *
	 * @var array
	 */
	protected $attributes = array();

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
}