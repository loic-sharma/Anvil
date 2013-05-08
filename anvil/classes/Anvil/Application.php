<?php namespace Anvil;

use Anvil\Auth\AuthManager as Auth;
use Anvil\Routing\UriInspector;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication {

	/**
	 * The URI inspector, which retrieves data about the current
	 * request from the URI.
	 *
	 * @var Anvil\Routing\UriInspector
	 */
	protected $inspector;

	/**
	 * Create a route to the detected current controller.
	 *
	 * @param  Anvil\Routing\UriInspector  $inspector
	 * @param  Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function start(UriInspector $inspector, Router $router)
	{
		$this->inspector = $inspector;

		$controller = $inspector->detectController();
		$uri = $inspector->detectUri();

		try
		{
			$router->controller($uri, $controller);
		}

		// If the controller does not exist, Laravel will
		// throw an exception. we'll silently kill the exception
		// since there might be a custom route already set.
		catch(\ReflectionException $e) {}
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
		return $this->inspector->isHome();
	}

	/**
	 * Determine if the current request is for the Admin panel.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->inspector->isAdmin();
	}
}