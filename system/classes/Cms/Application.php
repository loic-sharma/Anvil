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
		catch(ReflectionException $e)
		{
			if($e->getMessage() == "Class {$this->controller} does not exist")
			{
				throw new NotFoundHttpException;
			}

			else
			{
				throw new ReflectionException($e->getMessage());
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

		// If the request is empty, then we're home! Use the
		// default controller.
		if($uri == '/')
		{
			$this->controller = $this['settings']->get('defaultController');
			$this->isHome = true;
		}

		else
		{
			// If we have multiple segments, remove everything except
			// the first segment. We'll use the first segment for the
			// controller.
			$firstSlash = strpos($uri, '/');

			if($firstSlash !== false)
			{
				$uri = substr($uri, 0, $firstSlash);
			}

			$this->controller = ucfirst($uri).'Controller';

			// Let's check if we're home. To do: currently this will be false if
			// there is more than segment (even if we are home).
			if($this->controller == $this['settings']->get('defaultController') && $firstSlash == false)
			{
				$this->isHome = true;
			}
		}

		// Register the default route.
		$this['router']->controller($this->controller, $uri);
	}
}