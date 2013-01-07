<?php

class SettingsPlugin extends Plugin {

	/**
	 * Retrieve a setting.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		return Settings::get($key, $default);
	}

	/**
	 * Retrieve a setting.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return Settings::get($key);
	}

	/**
	 * Retrieve a setting.
	 *
	 * @param  string  $method
	 * @param  array   $args
	 * @return mixed
	 */
	public function __call($method, $args = array())
	{
		$default = empty($args) ? null : $args[0];

		return Settings::get($method, $default);
	}
}