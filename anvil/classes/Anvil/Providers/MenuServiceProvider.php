<?php namespace Anvil\Providers;

use Menu\Factory as MenuFactory;
use Menu\FilterRepository as MenuFilter;
use Menu\Renderer as MenuRenderer;

use Anvil\Menu\Menu as MenuRepository;
use Anvil\Menu\Models\Menu as MenuModel;
use Anvil\Plugins\NavigationPlugin;

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

		$this->registerMenuFactory();

		$this->registerMenu();

		$this->registerPlugin();
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
	 * Register the Menu Factory.
	 *
	 * @return void
	 */
	public function registerMenuFactory()
	{
		$this->app['menu.factory'] = $this->app->share(function($app)
		{
			return new MenuFactory($app['menu.filter'], $app['menu.renderer']);
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
			return new MenuRepository($app['menu.factory']);
		});
	}

	/**
	 * Register the menu's plugin.
	 *
	 * @return void
	 */
	public function registerPlugin()
	{
		$this->app['menu.plugin'] = $this->app->share(function($app)
		{
			return new NavigationPlugin($app['auth']->user(), new MenuModel, $app['menu']);
		});
	}
}