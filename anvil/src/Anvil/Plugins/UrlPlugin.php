<?php namespace Anvil\Plugins;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

class UrlPlugin {

	/**
	 * The current HttpRequest.
	 *
	 * @var Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * The URL Generator.
	 *
	 * @var Illuminate\Routing\UrlGenerator
	 */
	protected $url;

	/**
	 * Register the reques and Url.
	 *
	 * @param Illuminate\Http\Request  $request
	 * @param Illuminate\Routing\UrlGenerator  $url
	 */
	public function __construct(Request $request, UrlGenerator $url)
	{
		$this->request = $request;
		$this->url = $url;
	}

	/**
	 * Retrieve the base URL.
	 *
	 * @return string
	 */
	public function base()
	{
		return $this->request->root();
	}

	/**
	 * Retrieve the current URL.
	 *
	 * @return string
	 */
	public function current()
	{
		return $this->request->getUri();
	}

	/**
	 * Retrieve the URL to a certain URI.
	 *
	 * @param  string  $uri
	 * @return string
	 */
	public function to($uri)
	{
		return $this->url->to($uri);
	}
}