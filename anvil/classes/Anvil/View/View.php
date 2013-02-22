<?php namespace Anvil\View;

use Illuminate\View\View as IlluminateView;

class View extends IlluminateView {

	/**
	 * Automatically share anything that is set to a view.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		parent::__set($key, $value);

		$this->environment->share($key, $value);
	}
}