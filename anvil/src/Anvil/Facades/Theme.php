<?php namespace Anvil\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade {

	/**
	 * Get the current theme.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return static::$app['themes']->getTheme();
	}

}