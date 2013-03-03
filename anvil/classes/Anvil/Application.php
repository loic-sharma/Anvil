<?php namespace Anvil;

use Anvil\Auth\AuthManager as Auth;
use Anvil\Settings\Repository as Settings;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication {

	/**
	 * The current request's detected controller.
	 *
	 * @var string
	 */
	protected $controller;

	/**
	 * The current request's URI that corresponds to a route.
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * Is the current request the home page?
	 *
	 * @var bool
	 */
	protected $isHome = false;

	/**
	 * Is the current request for the admin panel?
	 *
	 * @var bool
	 */
	protected $isAdminPanel = false;

	/**
	 * Create a route to the detected current controller.
	 *
	 * @param  Illuminate\Http\Request    $request
	 * @param  Cms\Settings\Repository    $settings
	 * @param  Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function start(Request $request, Settings $settings, Router $router)
	{
		$uri = $request->path();
		$defaultController = $settings->get('defaultController');
		
		if($uri == '/')
		{
			$this->controller = $defaultController;
			$this->isHome = true;
		}

		else
		{
			$segments = explode('/', trim($uri, '/'));

			// Handle admin routing separately.
			if($segments[0] == 'admin')
			{
				$this->isAdminPanel = true;

				$this->setTheme('admin');

				// The second segment will be directly routed to a module.
				if(count($segments) >= 2)
				{
					$this->controller = ucfirst($segments[1]).'AdminController';
				}

				// Use the admin controller by default.
				else
				{
					$this->controller = 'Anvil\Controllers\AdminController';
				}
	
				$uri = implode('/', array_slice($segments, 0, 2));
			}

			// Handle normal non-admin routes.
			else
			{
				$uri = $segments[0];

				$this->controller = ucfirst($segments[0]).'Controller';

				// Let's do one last check to see if this is the home page.
				if($this->controller == $defaultController and ! isset($segments[1]))
				{
					$this->isHome = true;
				}
			}
		}

		try
		{
			$router->controller($uri, $this->controller);
		}

		// If the controller does not exist, Illuminate will
		// throw an exception. we'll silently kill the exception
		// Since there might be a custom route already set.
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
		return $this->isHome;
	}

	/**
	 * Determine if the current request is for the Admin panel.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->isAdminPanel;
	}
}