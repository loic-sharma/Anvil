<?php namespace Anvil\Providers;

use Illuminate\Support\ServiceProvider;
use Anvil\Settings\Repository as SettingsRepository;
use Anvil\Settings\DatabaseLoader;

class SettingsServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerSettingsLoader();
		$this->registerSettingsRepository();
	}

	/**
	 * Register the Settings Loader.
	 *
	 * @return void
	 */
	public function registerSettingsLoader()
	{
		$this->app['settings.loader'] = $this->app->share(function($app)
		{
			return new DatabaseLoader($app['db']);
		});
	}

	/**
	 * Register the Settings Repository.
	 *
	 * @return void
	 */
	public function registerSettingsRepository()
	{
		$this->app['settings'] = $this->app->share(function($app)
		{
			return new SettingsRepository($app['settings.loader']);
		});
	}
}