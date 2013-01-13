<?php namespace Cms\Routing;

use Illuminate\Routing\UrlGenerator as IlluminateUrlGenerator;

class UrlGenerator extends IlluminateUrlGenerator {

	/**
	 * Get the base URL.
	 *
	 * @return string
	 */
	public function base()
	{
		$scheme = $this->request->getScheme();
		$host   = $this->request->getHttpHost();
		$path   = $this->request->getBasePath();

		$baseUrl = $scheme.'://'.$host.$path;

		return rtrim($baseUrl, '/').'/';	
	}

	/**
	 * Retrieve the current URI.
	 *
	 * @return string
	 */
	public function current()
	{
		return $this->request->getUri();
	}

	/**
	 * Get the base URL for the request.
	 *
	 * @param  string  $scheme
	 * @return string
	 */
	protected function getRootUrl($scheme)
	{
		$root = $this->request->root();
		$root = $this->addIndex($root);

		$start = starts_with($root, 'http://') ? 'http://' : 'https://';

		return preg_replace('~'.$start.'~', $scheme, $root, 1);
	}

	/**
	 * Add the application index to the root URL.
	 *
	 * @param  string  $rootUrl
	 * @return string
	 */
	protected function addIndex($rootUrl)
	{
		if( ! str_contains($rootUrl, 'index.php'))
		{
			$rootUrl = rtrim($rootUrl, '/').'/index.php';
		}

		return $rootUrl;
	}

}