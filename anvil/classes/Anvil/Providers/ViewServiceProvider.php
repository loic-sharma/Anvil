<?php namespace Anvil\Providers;

use Illuminate\View\Environment;
use Illuminate\Support\MessageBag;
use Illuminate\View\ViewServiceProvider as IlluminateViewServiceProvider;
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

		$this->registerThemesPath();

		$this->registerThemePath();

		$this->registerBladeExtension();
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

	/**
	 * Parse JSON input parameters in blade views. This will parse
	 * strings like:
	 *
	 *   {{ $plugin->method({"param": "value"}) }}
	 *
	 * @return void
	 */
	public function registerBladeExtension()
	{
		$engine = $this->app['view.engine.resolver']->resolve('blade');

		$engine->getCompiler()->extend(function($value)
		{
			return preg_replace_callback("/\\$([a-zA-Z0-9_]*)->([a-zA-Z0-9_]*)\(\{(.+?)\}\)/s", function($match)
			{
				// Parse the input as JSON.
				$input = json_decode('{'.$match[3].'}', true);

				// The input is null if the JSON parsing failed. If
				// that happens, we will just return what was originally matched.
				if(is_null($input))
				{
					return $match[0];
				}

				// Otherwise, replace the input with the PHP array
				// representation of the JSON input.
				else
				{
					$input = str_replace("\n", "", var_export($input, true));

					return str_replace($match[0], '$'.$match[1].'->'.$match[2].'('.$input.')', $match[0]);
				}

			}, $value);
		});
	}
}