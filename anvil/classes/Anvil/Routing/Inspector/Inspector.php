<?php namespace Anvil\Routing\Inspector;

use Closure;

class Inspector {

	/**
	 * The default controller that should be returned if
	 * no matching route was found.
	 *
	 * @var string
	 */
	protected $defaultController;

	/**
	 * The registered inspectors that will inspect the URI.
	 *
	 * @var array
	 */
	protected $inspectors = array();

	/**
	 * Prepare the inspector.
	 *
	 * @param  string  $defaultController
	 * @return void
	 */
	public function __construct($defaultController)
	{
		$this->defaultController = $defaultController;
	}

	/**
	 * Add an inspector.
	 *
	 * @param  mixed  $inspector
	 * @return void
	 */
	public function addInspector($inspector)
	{
		$this->inspectors[] = $inspector;
	}

	/**
	 * Inspect a URI and attempt to find a matching route.
	 *
	 * @param  string  $uri
	 * @return Anvil\Inspector\Route
	 */
	public function inspect($request)
	{
		$route = new Route($request);

		// Let's loop through each inspector and inspect the URI.
		// If an inspector find a matching route, we will end the loop
		// and return that route.
		foreach($this->inspectors as $inspector)
		{
			if($inspector instanceof Closure)
			{
				$output = $inspector($route, $this->defaultController);
			}

			else
			{
				$output = $inspector->inspect($route, $this->defaultController);
			}

			if($output instanceof Route)
			{
				return $output;
			}
		}
	}
}