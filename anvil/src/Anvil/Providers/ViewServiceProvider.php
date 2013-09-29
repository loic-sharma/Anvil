<?php namespace Anvil\Providers;

use Illuminate\View\Environment;
use Illuminate\Support\MessageBag;
use Illuminate\View\ViewServiceProvider as IlluminateViewServiceProvider;

use Anvil\View\Themes;
use Anvil\View\FileViewFinder;
use Anvil\Plugins\PluginManager;

class ViewServiceProvider extends IlluminateViewServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		parent::register();

		$this->registerThemePath();

		$this->registerThemes();
	}

	/**
	 * Register the path to the themes.
	 *
	 * @return void
	 */
	public function registerThemePath()
	{
		$path = $this->app['path.base'].'/themes';

		$this->app['theme.path'] = realpath($path);
	}

	public function registerThemes()
	{
		$this->app['themes'] = $this->app->share(function($app)
		{
			return new Themes($app['theme.path'], $app['files'], $app['url'], $app['html']);
		});
	}

	/**
	 * Register the view finder implementation.
	 *
	 * @return void
	 */
	public function registerViewFinder()
	{
		$this->app['view.finder'] = $this->app->share(function($app)
		{
			$finder = new FileViewFinder($app, $app['files']);

			$finder->setThemePath($app['theme.path']);
			$finder->setModulePath($app['module.path']);

			return $finder;
		});
	}

	/**
	 * Register the view environment.
	 *
	 * @return void
	 */
	public function registerEnvironment()
	{
		$me = $this;

		$this->app['view'] = $this->app->share(function($app) use ($me)
		{
			// Next we need to grab the engine resolver instance that will be used by the
			// environment. The resolver will be used by an environment to get each of
			// the various engine implementations such as plain PHP or Blade engine.
			$resolver = $app['view.engine.resolver'];

			$finder = $app['view.finder'];

			$env = new Environment($resolver, $finder, $app['events']);

			// We will also set the container instance on this view environment since the
			// view composers may be classes registered in the container, which allows
			// for great testable, flexible composers for the application developer.
			$env->setContainer($app);

			$env->share('app', $app);
			$env->share('message', $app['session']->get('message'));

			return $env;
		});
	}
}