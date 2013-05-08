<?php namespace Anvil\Routing;

class UriInspector {

	/**
	 * The current URI to detect routes off of.
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * The controller that should be routed to if the request
	 * is for the home page.
	 *
	 * @var string
	 */
	protected $defaultController;

	/**
	 * The segments of the request's URI.
	 *
	 * @var array
	 */
	protected $segments = array();

	/**
	 * Wether or not the current URI maps to the home page.
	 *
	 * @var bool
	 */
	protected $isHome;

	/**
	 * The controller for the home page of the admin panel.
	 *
	 * @var string
	 */
	const ADMIN_HOME_CONTROLLER = 'Anvil\Controllers\AdminController';

	/**
	 * Prepare the dependencies for the Inspector.
	 *
	 * @param  string  $uri
	 * @param  string  $defaultController
	 * @return void
	 */
	public function __construct($uri = null, $defaultController = null)
	{
		$this->uri = $uri;
		$this->defaultController = $defaultController;
	}

	/**
	 * Detect the controller that should respond to the current
	 * route.
	 *
	 * @return string
	 */
	public function detectController()
	{
		// Routing is handled slightly differently for the admin panel.
		// Let's take care of that independently from routes for the rest
		// of the site.
		if($this->isAdmin())
		{
			// We are on the admin panel's home page if there is only
			// one segment in the URI.
			if(count($this->getSegments()) == 1)
			{
				return static::ADMIN_HOME_CONTROLLER;
			}

			// Otherwise, let's get the controller for the current URI.
			// We'll use the second segment of the URI for the controller.
			else
			{
				return $this->formatAdminController($this->getSegment(1));
			}
		}

		else
		{
			if($this->isHome())
			{
				return $this->defaultController;
			}

			// Use the first segment of the URI for the route's controller.
			else
			{
				return $this->formatController($this->getSegment(0));
			}
		}
	}

	/**
	 * Detect the URI that should be routed to the controller.
	 *
	 * @return string
	 */
	public function detectUri()
	{
		if($this->uri == '/')
		{
			return $this->uri;
		}

		else
		{
			// If this is an admin route, fetch the first two segments.
			if($this->isAdmin())
			{
				return implode('/', array_slice($this->getSegments(), 0, 2));
			}

			// Otherewise, the URI will be just the first segment.
			else
			{
				return $this->getSegment(0);
			}
		}
	}

	/**
	 * Check if the current URI routes to the home page.
	 *
	 * @return bool
	 */
	public function isHome()
	{
		if(is_null($this->isHome))
		{
			$this->isHome = false;

			// The home page can be accessed two ways: through an empty
			// URI or through the full route to the default controller.
			// Let's check if the URI is empty first.
			if($this->uri == '/')
			{
				$this->isHome = true;
			}

			// The URI is not empty. Let's check if the current route
			// maps to the default controller.
			else
			{
				// The home page cannot be on the admin panel.
				if( ! $this->isAdmin())
				{
					$currentController = $this->getSegment(0);
					$currentController = $this->formatController($currentController);

					if($currentController == $this->defaultController)
					{
						// One last thing! We need to make sure that the current
						// URI does not map to a sub-page on the current controller.
						// Let's just check that there isn't an additional segment.
						if($this->getSegment(1) === null)
						{
							$this->isHome = true;
						}
					}
				}
			}
		}

		return $this->isHome;
	}

	/**
	 * Check if the current URI routes to the admin panel.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return ($this->getSegment(0) == 'admin');
	}

	/**
	 * Get the segments for the current URI.
	 *
	 * @return array
	 */
	protected function getSegments()
	{
		if(empty($this->segments))
		{
			$this->segments = explode('/', trim($this->uri, '/'));
		}

		return $this->segments;
	}

	/**
	 * Fetch a specific segment.
	 *
	 * @param  int    $segment
	 * @param  mixed  $default
	 * @return mixed
	 */
	protected function getSegment($segment, $default = null)
	{
		$segments = $this->getSegments();

		if(isset($segments[$segment]))
		{
			return $segments[$segment];
		}

		else
		{
			return $default;
		}
	}

	/**
	 * Format a string to fit the naming convention for controllers.
	 *
	 * @param  string  $controller
	 * @param  bool    $admin
	 * @return string
	 */
	protected function formatController($controller, $admin = false)
	{
		$suffix = $admin ? 'AdminController' : 'Controller';

		return ucfirst($controller).$suffix;
	}

	/**
	 * Format a string to fit the naming conventions for an admin controller.
	 *
	 * @param  string  $controller
	 * @return string
	 */
	protected function formatAdminController($controller)
	{
		return $this->formatController($controller, true);
	}
}