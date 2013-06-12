<?php namespace Anvil;

use Anvil\Auth\AuthManager as Auth;
use Anvil\Routing\Inspector\Inspector;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application as IlluminateApplication;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;

class Application extends IlluminateApplication {

	/**
	 * The route detected from the requested URI.
	 *
	 * @var Anvil\Routing\Inspector\Route
	 */
	protected $route;

	/**
	 * Get the configuration loader instance.
	 *
	 * @return \Illuminate\Config\LoaderInterface
	 */
	public function getConfigLoader()
	{
		return new FileLoader(new Filesystem, $this['path.base'].'/config');
	}

	/**
	 * Redirect to the installer if the database configuration is empty.
	 *
	 * @param  test
	 * @return void
	 */
	public function redirectIfUninstalled($config)
	{
		if(empty($config['database']))
		{
			with(new SymfonyRedirect($this['url']->base().'installer/', 301))->send();

			exit;
		}
	}

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
		// respond to the current request. If the route is null,
		// then the inspector could not find a matching route and
		// controller. Let's just abort with a 404 error message.
		if( ! ($this->route = $inspector->inspect($request)))
		{
			$this->abort(404);
		}

		// Otherwise, let's attempt to register the detected route.
		else
		{
			// If the controller does not exist, Laravel will
			// throw an exception. We will silently kill the exception
			// since there might be a custom route already set.
			try
			{
				$router->controller($this->route->route, $this->route->controller);
			}

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
		$this->make('themes')->setTheme($theme);
	}

	/**
	 * Fetch the current theme.
	 *
	 * @return string
	 */
	public function getTheme()
	{
		return $this->make('themes')->getCurrentTheme();
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