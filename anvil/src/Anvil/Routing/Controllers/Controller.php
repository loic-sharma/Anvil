<?php namespace Anvil\Routing\Controllers;

use Settings;
use Illuminate\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Controller as IlluminateController;

class Controller extends IlluminateController {

	/**
	 * The Page Plugin instance.
	 *
	 * @var PagePlugin
	 */
	public $page;

	/**
	 * Setup the page.
	 *
	 * @param  Illuminate\Container  $container
	 * @param  Illuminate\Routing\Router  $router
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return Symfony\Component\HttpFoundation\Response
	 */
	public function callAction(Container $container, Router $router, $method, $parameters)
	{
		$this->filterParser = $container['filter.parser'];

		// If no response was returned from the before filters, we'll call the regular
		// action on the controller and prepare the response. Then we will call the
		// after filters on the controller to wrap up any last minute processing.
		$response = $this->callBeforeFilters($router, $method);

		if (is_null($response))
		{
			$this->page = $container->plugins->page;

			$response = $this->callMethod($method, $parameters);

			if(is_null($response))
			{
				$response = $this->page->render();
			}
		}

		return $this->processResponse($router, $method, $response);
	}
}