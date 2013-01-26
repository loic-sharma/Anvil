<?php namespace Cms\Providers;

use Illuminate\View\Environment;
use Illuminate\Support\MessageBag;
use Illuminate\View\ViewServiceProvider as IlluminateViewServiceProvider;
use Cms\View\FileViewFinder;
use Cms\Plugins\PluginManager;

class ViewServiceProvider extends IlluminateViewServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerThemesPath();
		$this->registerThemePath();

		parent::register();
	}

	/**
	 * Register the path to the themes.
	 *
	 * @return void
	 */
	public function registerThemesPath()
	{
		$this->app['themes.path'] = $this->app['path.base'].'/themes';
	}

	/**
	 * Register the theme path.
	 *
	 * @return void
	 */
	public function registerThemePath()
	{
		$this->app['theme.path'] = $this->app->share(function($app)
		{
			$currentTheme = $app['settings']->get('theme');

			return $app['themes.path'].'/'.$currentTheme;
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
			$finder = new FileViewFinder($app['files']);

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

			$events = $app['events'];

			$environment = new Environment($resolver, $finder, $events);

			// If the current session has an "errors" variable bound to it, we will share
			// its value with all view instances so the views can easily access errors
			// without having to bind. An empty bag is set when there aren't errors.
			if ($me->sessionHasErrors($app))
			{
				$errors = $app['session']->get('errors');

				$environment->share('errors', $errors);
			}

			// Putting the errors in the view for every view allows the developer to just
			// assume that some errors are always available, which is convenient since
			// they don't have to continually run checks for the presence of errors.
			else
			{
				$environment->share('errors', new MessageBag);
			}

			// We will also set the container instance on this view environment since the
			// view composers may be classes registered in the container, which allows
			// for great testable, flexible composers for the application developer.
			$environment->setContainer($app);

			$environment->share('app', $app);
			$environment->share('plugins', $app['plugins']);

			return $environment;
		});
	}
}