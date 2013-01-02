<?php

namespace Cms\Plugins;

class UrlPlugin extends Plugin {

	/**
	 * Retrieve the base URL.
	 *
	 * @return string
	 */
	public function base()
	{
		return static::$app['request']->root();
	}

	/**
	 * Retrieve the current URL.
	 *
	 * @return string
	 */
	public function current()
	{
		// Todo.
		//throw new \Exception;

		return '';
	}

	/**
	 * Retrieve the URL to a certain URI.
	 *
	 * @param  string  $uri
	 * @return string
	 */
	public function to($uri)
	{
		return static::$app['url']->to($uri);
	}
}