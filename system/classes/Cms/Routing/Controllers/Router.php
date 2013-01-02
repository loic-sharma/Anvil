<?php

namespace Cms\Routing\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router as IlluminateRouter;
use Cms\Settings\Repository as Settings;

class Router {

	protected $currentUri;
	protected $settings;
	protected $router;

	protected $uri;
	protected $controller;

	protected $isHome = false;

	public function __construct(Request $request, Settings $settings, IlluminateRouter $router)
	{
		$this->currentUri = $request->path();
		$this->settings = $settings;
		$this->router = $router;
	}

	public function isHome()
	{
		return $this->isHome;
	}

	public function setDefaultRoute()
	{
		if($this->currentUri == '/')
		{
			$this->uri = '';
			$this->controller = $this->settings->get('defaultController');

			$this->isHome = true;
		}

		else
		{
			$firstSlash = strpos($this->currentUri, '/');

			if($firstSlash !== false)
			{
				$this->uri = substr($this->currentUri, 0, $firstSlash);
			}

			else
			{
				$this->uri = $this->currentUri;
			}

			$this->controller = ucfirst($this->uri).'Controller';
		}

		$this->router->controller($this->controller, $this->uri);
	}

	public function exceptionMessage()
	{
		return "Class {$this->controller} does not exist";
	}
}