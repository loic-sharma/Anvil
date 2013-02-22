<?php namespace Anvil\Plugins;

use Url;
use Request;

class UrlPlugin {

	/**
	 * Retrieve the base URL.
	 *
	 * @return string
	 */
	public function base()
	{
		return Request::root();
	}

	/**
	 * Retrieve the current URL.
	 *
	 * @return string
	 */
	public function current()
	{
		return Request::getUri();
	}

	/**
	 * Retrieve the URL to a certain URI.
	 *
	 * @param  string  $uri
	 * @return string
	 */
	public function to($uri)
	{
		return Url::to($uri);
	}
}