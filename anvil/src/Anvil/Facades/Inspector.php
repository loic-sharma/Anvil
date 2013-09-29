<?php namespace Anvil\Facades;

use Illuminate\Support\Facades\Facade;

class Inspector extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'routing.inspector'; }
}