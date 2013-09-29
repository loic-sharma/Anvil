<?php namespace Anvil\Routing\Inspector;

class AdminInspector {

	/**
	 * The default controller for the admin panel.
	 *
	 * @var string
	 */
	protected $adminHomeController = 'Anvil\Controllers\AdminController';

	/**
	 * Inspect the request and see if it is for the admin panel.
	 *
	 * @param  Anvil\Routing\Inspector\Route  $route
	 * @return mixed
	 */
	public function inspect(Route $route)
	{
		$uriSegments = explode('/', $route->request->path());

		// The URI starts with "admin", it's a request for the admin panel.
		if(isset($uriSegments[0]) and $uriSegments[0] == 'admin')
		{
			$route->isAdmin = true;

			// If there is only one URI segment, this is a request for the
			// admin panel's home page. This has a special controller, so
			// let's take care of that now.
			if(count($uriSegments) == 1)
			{
				$route->route = 'admin';
				$route->controller = $this->adminHomeController;
			}

			// Otherwise, the request is just a regular request for an admin
			// panel controller. The route will just be the first two segments
			// of the URI.
			else
			{
				$route->route = $uriSegments[0].'/'.$uriSegments[1];
				$route->controller = $this->formatController($uriSegments[1]);
			}

			return $route;
		}
	}

	/**
	 * Format a string into a controller.
	 *
	 * @param  string  $controller
	 * @return string
	 */
	public function formatController($controller)
	{
		return ucfirst($controller).'AdminController';
	}
}