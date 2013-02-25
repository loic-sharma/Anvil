<?php namespace Anvil\Providers;

use Anvil\Plugins\UrlPlugin;
use Anvil\Routing\UrlGenerator;

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

		$this->registerUrlPlugin();
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
	 * Register the URRL plugin.
	 *
	 * @return void
	 */
	protected function registerUrlPlugin()
	{
		$this->app['url.plugin'] = $this->app->share(function($app)
		{
			return new UrlPlugin($app['request'], $app['url']);
		});
	}
}