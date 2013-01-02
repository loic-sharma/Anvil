<?php

namespace Cms\View;

use Illuminate\View\View as IlluminateView;

class View extends IlluminateView {

	public function __set($key, $value)
	{
		parent::__set($key, $value);

		$this->environment->share($key, $value);
	}
}