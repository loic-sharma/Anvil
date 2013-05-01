<?php namespace Anvil\Settings;

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
	}

	/**
	 * Save the settings.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		// Save the settings only if they have already been loaded. 
		if( ! is_null($this->settings))
		{
			$this->loader->save($this->settings);
		}
	}

	/**
	 * Fetch the settings if they haven't been
	 * loaded yet.
	 *
	 * @return array
	 */
	public function fetch()
	{
		if(is_null($this->settings))
		{
			$this->settings = $this->loader->get();
		}

		return $this->settings;
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
		$this->fetch();

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
		$this->fetch();

		$this->settings[$key] = $value;
	}
}