<?php namespace Cms\Plugins;

class UrlPlugin {

	/**
	 * The application container.
	 *
	 * @var Cms\Application
	 */
	protected $app;

	/**
	 * Get the application container.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->app = app();
	}

	/**
	 * Retrieve the base URL.
	 *
	 * @return string
	 */
	public function base()
	{
		return $this->app->request->root();
	}

	/**
	 * Retrieve the current URL.
	 *
	 * @return string
	 */
	public function current()
	{
		return $this->app->request->getUri();
	}

	/**
	 * Retrieve the URL to a certain URI.
	 *
	 * @param  string  $uri
	 * @return string
	 */
	public function to($uri)
	{
		return $this->app->url->to($uri);
	}
}