<?php

namespace Cms;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication {

	/**
	 * The current request's detected controller.
	 *
	 * @var string
	 */
	protected $controller;

	/**
	 * Is the current request the home page?
	 *
	 * @var bool
	 */
	protected $isHome = false;

	/**
	 * Run the application.
	 *
	 * @return void
	 */
	public function run()
	{
		// Try to run the application.
		try
		{
			parent::run();
		}

		// Because of the default routing system, it is possible that the CMS
		// created a route to a nonexistent controller. If that happens, let's
		// throw a more accurate exception.
		catch(\ReflectionException $e)
		{
			if($e->getMessage() == "Class {$this->controller} does not exist")
			{
				throw new NotFoundHttpException;
			}

			else
			{
				throw new \ReflectionException($e->getMessage());
			}
		}
	}

	/**
	 * Determine if the current request is the home page.
	 *
	 * @return bool
	 */
	public function isHome()
	{
		return $this->isHome;
	}

	/**
	 * Create a route to the detected current controller.
	 *
	 * @return void
	 */
	public function setDefaultRoute()
	{
		$uri = $this['request']->path();
		$defaultController = $this['settings']->get('defaultController');
		
		if($uri == '/')
		{
			$this->controller = $defaultController;
			$this->isHome = true;
		}

		else
		{
			$segments = explode('/', $uri);

			// Handle admin routing separately.
			if($segments[0] == 'admin')
			{
				$uri = implode('/', array_slice($segments, 0, 2));

				// The second segment will be directly routed to a module.
				if(count($segments) >= 2)
				{
					$this->controller = ucfirst($segments[1]).'AdminController';
				}

				else
				{
					// By default, use the admin controller.
					$this->controller = 'AdminController';
				}
			}

			// Handle normal non-admin routes.
			else
			{
				$uri = $segments[0];

				$this->controller = ucfirst($segments[0]).'Controller';

				// Let's do one last check to see if this is the home page.
				if($this->controller == $defaultController && ! isset($segments[1]))
				{
					$this->isHome = true;
				}
			}
		}

		$this['router']->controller($this->controller, $uri);
	}
}