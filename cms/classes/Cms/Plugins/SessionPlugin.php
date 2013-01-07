<?php

namespace Cms\Plugins;

class SessionPlugin extends Plugin {

	/**
	 * Retrieve all error messages.
	 *
	 * @return array
	 */
	public function messages($format = null)
	{
		$shared = static::$app->make('view')->getShared();

		return $shared['errors']->all($format);
	}
}