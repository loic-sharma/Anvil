<?php namespace Cms\Facades;

use Illuminate\Support\Facades\Facade;

class Anvil extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return static::$app; }
}