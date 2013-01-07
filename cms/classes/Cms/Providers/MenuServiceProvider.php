<?php

namespace Cms\Providers;

use Menu\Factory as MenuFactory;
use Menu\FilterRepository as MenuFilter;
use Menu\Renderer as MenuRenderer;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerMenuFilterRepository();

		$this->registerMenuRenderer();

		$this->registerMenu();
	}

	/**
	 * Register the Menu Filter.
	 *
	 * @return void
	 */
	public function registerMenuFilterRepository()
	{
		$this->app['menu.filter'] = $this->app->share(function($app)
		{
			return new MenuFilter;
		});
	}

	/**
	 * Register the Menu Renderer.
	 *
	 * @return void
	 */
	public function registerMenuRenderer()
	{
		$this->app['menu.renderer'] = $this->app->share(function($app)
		{
			return new MenuRenderer;
		});
	}

	/**
	 * Register the Menu.
	 *
	 * @return void
	 */
	public function registerMenu()
	{
		$this->app['menu'] = $this->app->share(function($app)
		{
			return new MenuFactory($app['menu.filter'], $app['menu.renderer']);
		});
	}
}