<?php

namespace Cms\Facades;

use Illuminate\Support\Facades\Facade;

class Modules extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'modules'; }
}