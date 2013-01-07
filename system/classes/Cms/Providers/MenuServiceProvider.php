<?php

namespace Cms\Providers;

use Menu\Factory as MenuFactory;
use Menu\FilterRepository as MenuFilter;
use Menu\Renderer as MenuRenderer;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

	/**
	 * Register the UhOh Exception Handler.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerMenuFilterRepository();

		$this->registerMenuRenderer();

		$this->registerMenu();
	}

	public function registerMenuFilterRepository()
	{
		$this->app['menu.filter'] = $this->app->share(function($app)
		{
			return new MenuFilter;
		});
	}

	public function registerMenuRenderer()
	{
		$this->app['menu.renderer'] = $this->app->share(function($app)
		{
			return new MenuRenderer;
		});
	}

	public function registerMenu()
	{
		$this->app['menu'] = $this->app->share(function($app)
		{
			return new MenuFactory($app['menu.filter'], $app['menu.renderer']);
		});
	}
}