<?php namespace Anvil\Providers;

use Illuminate\Support\ServiceProvider;
use Anvil\Modules\Repository as ModuleRepository;
use Anvil\Modules\DatabaseLoader;
use Anvil\Plugins\PluginManager;
use Anvil\Plugins\Plugin;

class ModuleServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerModulePath();
		$this->registerModuleLoader();
		$this->registerModules();
		$this->registerPlugins();
	}

	/**
	 * Register the module path.
	 *
	 * @return void
	 */
	public function registerModulePath()
	{
		$path = $this->app['path.base'].'modules';

		$this->app->instance('module.path', realpath($path));
	}

	/**
	 * Register the Module Loader.
	 *
	 * @return void
	 */
	public function registerModuleLoader()
	{
		$this->app['module.loader'] = $this->app->share(function($app)
		{
			return new DatabaseLoader($app['db']);
		});
	}

	/**
	 * Register the Module Repository.
	 *
	 * @return void
	 */
	public function registerModules()
	{
		$this->app['modules'] = $this->app->share(function($app)
		{
			return new ModuleRepository($app['files'], $app['autoloader'], $app['module.loader'], $app['module.path']);
		});
	}

	/**
	 * Register the Plugin Manager.
	 *
	 * @return void
	 */
	public function registerPlugins()
	{
		$this->app['plugins'] = $this->app->share(function($app)
		{
			Plugin::setApplication($app);

			return new PluginManager($app, $app['view']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('menu.loader', 'modules', 'plugins');
	}
}