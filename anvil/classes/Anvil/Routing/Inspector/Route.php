<?php namespace Anvil\Routing\Inspector;

class Route {

	/**
	 * The current request.
	 *
	 * @var Illuminate\Http\Request
	 */
	public $request;

	/**
	 * The route to handle the current request.
	 *
	 * @var string
	 */
	public $route;

	/**
	 * The controller that handles the route.
	 *
	 * @var string
	 */
	public $controller;

	/**
	 * Wether or not this route is for the home page.
	 *
	 * @var bool
	 */
	public $isHome = false;

	/**
	 * Wether or not this route is for the admin panel.
	 *
	 * @var bool
	 */
	public $isAdmin = false;

	/**
	 * Prepare the current route.
	 *
	 * @param  string  $uri
	 */
	public function __construct($request)
	{
		$this->request = $request;
	}
}