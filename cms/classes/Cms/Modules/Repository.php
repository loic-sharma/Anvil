<?php namespace Cms\Modules;

use Composer\Autoload\ClassLoader;

class Repository {

	/**
	 * The instance of the composer Class Loader.
	 *
	 * @var ClassLoader
	 */
	protected $autoloader;

	/**
	 * The path to modules.
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * The registered modules.
	 *
	 * @var array
	 */
	protected $modules = array();

	/**
	 * The modules that have been booted.
	 *
	 * @var array
	 */
	protected $booted = array();

	/**
	 * Get the registered modules.
	 *
	 * @param  ClassLoader      $autoloader
	 * @param  LoaderInterface  $loader
	 * @param  string           $path
	 * @return void
	 */
	public function __construct(ClassLoader $autoloader, LoaderInterface $loader, $path)
	{
		$this->autoloader = $autoloader;
		$this->modules = $loader->get();
		$this->path = $path;
	}

	/**
	 * Get a specific module, or all of the registered moules.
	 *
	 * @param  string  $module
	 * @return array
	 */
	public function get($module = null)
	{
		if( ! is_null($module))
		{
			return $this->modules[$module];
		}

		else
		{
			return $this->modules;
		}
	}

	/**
	 * Get the registered modules that are enabled.
	 *
	 * @return array
	 */
	public function getEnabledModules()
	{
		$modules = array();

		foreach($this->modules as $module)
		{
			if($module->enabled == true)
			{
				$modules[] = $module;
			}
		}

		return $modules;
	}

	/**
	 * Get the path to a module.
	 *
	 * @param  string  $module
	 * @return string
	 */
	public function getPath($module = null)
	{
		if( ! is_null($module))
		{
			$module .= '/';
		}

		return $this->path.'/'.$module;
	}

	/**
	 * Verify if that a module exists.
	 *
	 * @param  string  $module
	 * @return bool
	 */
	public function exists($module)
	{
		if(in_array($module, $this->booted))
		{
			return true;
		}

		return is_dir($this->getPath($module));
	}

	/**
	 * Load a module.
	 *
	 * @param  string  $module
	 * @return void
	 */
	public function boot($module)
	{
		if( ! in_array($module, $this->booted))
		{
			$path = $this->getPath($module);

			if(is_dir($path))
			{
				// Add the module's controller and model directories (if they exist)
				// to the autoloader's list of directories.
				$directories = array($path.'controllers', $path.'models');

				$directories = array_filter($directories, function($directory)
				{
					return is_dir($directory);
				});

				$this->autoloader->add(null, $directories);
				$this->autoloader->add(ucfirst($module), $path.'classes');

				// Load the module's start file, routes, filters, and plugin
				// if they exist.
				foreach(array('start', 'routes', 'filters', 'events', 'plugin') as $file)
				{
					if(file_exists($path.$file.'.php'))
					{
						include $path.$file.'.php';
					}
				}

				$plugin = ucfirst($module).'Plugin';

				// Todo: Dependency injection?
				if(class_exists($plugin))
				{
					app()->plugins->register($module, $plugin);
				}

				app()->view->addNamespace($module, $path.'views');
			}

			else
			{
				throw new \InvalidArgumentException("Module [$module] does not exist.");
			}

			$this->booted[] = $module;
		}
	}
}