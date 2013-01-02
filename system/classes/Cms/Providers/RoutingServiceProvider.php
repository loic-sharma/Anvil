<?php namespace Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Cms\Routing\UrlGenerator;
use Cms\Routing\Controllers\Router as ControllerRouter;
use Illuminate\Routing\RoutingServiceProvider as IlluminateRoutingServiceProvider;

class RoutingServiceProvider extends IlluminateRoutingServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		parent::register();

		$this->registerControllerRouter();
	}

	/**
	 * Register the URL generator service.
	 *
	 * @return void
	 */
	protected function registerUrlGenerator()
	{
		$this->app['url'] = $this->app->share(function($app)
		{
			// The URL generator needs the route collection that exists on the router.
			// Keep in mind this is an object, so we're passing by references here
			// and all the registered routes will be available to the generator.
			$routes = $app['router']->getRoutes();

			return new UrlGenerator($routes, $app['request']);
		});
	}

	/**
	 * Register the Controller Router.
	 *
	 * @return void
	 */
	public function registerControllerRouter()
	{
		$this->app['controller.router'] = $this->app->share(function($app)
		{
			return new ControllerRouter($app['request'], $app['settings'], $app['router']);
		});
	}
}