<?php namespace Anvil\Routing\Inspector;

class ModuleInspector {

	/**
	 * Attempt to match the current request to one of the
	 * modules' controllers.
	 *
	 * @param  Anvil\Routing\Inspector\Route  $route
	 * @param string                          $defaultController
	 * @return mixed
	 */
	public function inspect(Route $route, $defaultController)
	{
		// The request is for the home page if the URI is empty.
		if($route->request->path() == '/')
		{
			$route->controller = $defaultController;
			$route->route = '/';
			$route->isHome = true;
		}

		else
		{
			$uriSegments = explode('/', $route->request->path());

			$route->controller = $this->formatController($uriSegments[0]);
			$route->route = $uriSegments[0];

			// One last thing! Let's see if the URI mapped to the home page.
			if(count($uriSegments) == 1 and $route->controller == $defaultController)
			{
				$route->isHome = true;
			}
		}

		return $route;
	}

	/**
	 * Format a string into a controller.
	 *
	 * @param  string  $controller
	 * @return string
	 */
	public function formatController($controller)
	{
		return ucfirst($controller).'Controller';
	}
}