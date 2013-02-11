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

}