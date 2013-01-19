<?php namespace Cms\Settings;

class Repository {

	/**
	 * The settings loader.
	 *
	 * @var Cms\Settings\LoaderInterface
	 */
	protected $loader;

	/**
	 * The current settings.
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Create a new Settings Repository instance.
	 *
	 * @param  Cms\Settings\LoaderInterface  $loader
	 * @return void
	 */
	public function __construct(LoaderInterface $loader)
	{
		$this->loader = $loader;
		$this->settings = $this->loader->get();
	}

	/**
	 * Save the settings.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		if( ! is_null($this->settings))
		{
			$this->loader->save($this->settings);
		}
	}

	/**
	 * Retrieve a setting.
	 *
	 * @param  string  $key
	 * @param  mixed   $defaultValue
	 * @return mixed
	 */
	public function get($key, $defaultValue = null)
	{
		if(isset($this->settings[$key]))
		{
			return $this->settings[$key];
		}

		else
		{
			return $defaultValue;
		}
	}

	/**
	 * Set the value of a setting.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set($key, $value)
	{
		$this->settings[$key] = $value;
	}
}