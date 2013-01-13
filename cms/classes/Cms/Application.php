<?php namespace Cms;

use Cms\Auth\AuthManager as Auth;
use Cms\Settings\Repository as Settings;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Application as IlluminateApplication;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
	 * Determine if the current request is for the Admin panel.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->isAdminPanel;
	}

	/**
	 * Create a route to the detected current controller.
	 *
	 * @param  Illuminate\Http\Request    $request
	 * @param  Cms\Settings\Repository    $settings
	 * @param  Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function start(Request $request, Settings $settings, Auth $auth, Router $router)
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
			$segments = explode('/', $uri);

			// Handle admin routing separately.
			if($segments[0] == 'admin')
			{
				$this->isAdminPanel = true;

				// Let's make sure the user is actually an
				// admin. Otherwise, redirect to the home page.
				if($auth->check())
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
						$this->controller = 'Cms\Controllers\AdminController';
					}

					// Register the admin template.
					$this['template.path'] = $this['path.base'].'/templates/admin';

					$this['view.finder']->setTemplatePath($this['template.path']);
					$this['plugins']->template->setTemplate('admin');
				}

				else
				{
					throw new NotFoundHttpException;
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

		$router->controller($this->controller, $uri);
	}
}