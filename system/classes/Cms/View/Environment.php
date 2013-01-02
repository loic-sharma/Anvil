<?php

namespace Cms\View;

use Illuminate\View\Environment as IlluminateEnvironment;

class Environment extends IlluminateEnvironment {

	/**
	 * Get a evaluated view contents for the given view.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return Illuminate\View\View
	 */
	public function make($view, array $data = array())
	{
		$path = $this->finder->find($view);

		$plugins = $this->shared['plugins']->all();

		foreach(array_merge($plugins, $data) as $key => $value)
		{
			$this->shared[$key] = $value;
		}

		return new View($this, $this->getEngineFromPath($path), $view, $path, $data);
	}
}