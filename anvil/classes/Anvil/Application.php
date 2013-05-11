<?php namespace Anvil;

use Anvil\Auth\AuthManager as Auth;
use Anvil\Routing\Inspector\Inspector;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication {

	/**
	 * The route detected from the requested URI.
	 *
	 * @var Anvil\Routing\Inspector\Route
	 */
	protected $route;

	/**
	 * Create a route to the detected current controller.
	 *
	 * @param  Illuminate\Http\Request    $request
	 * @param  Anvil\Routing\Inspector    $inspector
	 * @param  Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function start(Request $request, Inspector $inspector, Router $router)
	{
		// Let's pass the request to the inspector. The inspector
		// will determine which route and controller that should
		// respond to the current request.
		$this->route = $inspector->inspect($request);

		// If the route is null, then the inspector could not find
		// a matching route and controller. Let's just abort with a
		// 404 error message.
		if(is_null($this->route))
		{
			$this->abort(404);
		}

		// Otherwise, let's attempt to register the detected route.
		else
		{
			try
			{
				$router->controller($this->route->route, $this->route->controller);
			}

			// If the controller does not exist, Laravel will
			// throw an exception. we'll silently kill the exception
			// since there might be a custom route already set.
			catch(\ReflectionException $e) {}
		}
	}

	/**
	 * Set the site's current theme.
	 *
	 * @param  string  $theme
	 * @return void
	 */
	public function setTheme($theme)
	{
		$this['theme.path'] = $this['path.base'].'/themes/'.$theme;

		$this['view.finder']->setThemePath($this['theme.path']);
		$this['plugins']->theme->setTheme($theme);
	}

	/**
	 * Run the application.
	 *
	 * @return void
	 */
	public function run()
	{
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
				$this->abort(404);
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
		return $this->route->isHome;
	}

	/**
	 * Determine if the current request is for the Admin panel.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->route->isAdmin;
	}
}