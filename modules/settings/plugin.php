<?php

class SettingsPlugin extends Plugin {

	public function __get($key)
	{
		return Settings::get($key, null);
	}

	public function __call($method, $args = array())
	{
		$default = empty($args) ? null : $args[0];

		return Settings::get($method, $default);
	}
}