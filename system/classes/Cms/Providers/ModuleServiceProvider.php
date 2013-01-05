<?php namespace Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Cms\Modules\Repository as ModuleRepository;
use Cms\Modules\DatabaseLoader;
use Cms\Plugins\PluginManager;
use Cms\Plugins\Plugin;

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
		$this->app['module.path'] = $this->app['path.base'].'/modules';
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
			return new ModuleRepository($app['autoloader'], $app['module.loader'], $app['module.path']);
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

			return new PluginManager($app);
		});
	}
}