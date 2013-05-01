<?php namespace Anvil\Modules;

use Anvil;

class Module {

	/**
	 * The module repository.
	 *
	 * @var Anvil\Modules\Repository
	 */
	protected $modules;

	/**
	 * The module's data.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * The directories in a module that contain classes.
	 *
	 * @var array
	 */
	protected $directories = array('controllers', 'models');

	/**
	 * Wether the module has been loaded or not.
	 *
	 * @var bool
	 */
	protected $booted = false;

	/**
	 * Prepare the module's data.
	 *
	 * @param  array  $data
	 * @return void
	 */
	public function __construct(Repository $modules, $data)
	{
		$this->modules = $modules;
		$this->data = $data;

		$this->autoloader = $this->modules->getAutoloader();
		$this->filesystem = $this->modules->getFiles();
	}

	/**
	 * Boot the module.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Make sure the module exists before trying to load it.
		if($this->filesystem->isDirectory($path = $this->getPath()))
		{
			$this->addClassPaths($path);

			$this->loadStartFiles($path);

			$this->loadPlugin($path);
		}

		// The module's directory cannot be found. Let's throw an exception!
		else
		{
			throw new \InvalidArgumentException("Module [{$this->data->slug}] does not exist.");
		}
	}

	/**
	 * Fetch the module's path.
	 *
	 * @return string
	 */
	protected function getPath()
	{
		return $this->modules->getPath($this->data->slug);
	}

	/**
	 * Add the module's classes to the autoloader.
	 *
	 * @param  string  $path
	 * @return void
	 */
	protected function addClassPaths($path)
	{
		$directories = $this->getExistingDirectories($path);
	
		$this->autoloader->add(null, $directories);
		$this->autoloader->add(ucfirst($this->data->slug), $path.'classes');
	}

	/**
	 * Load the module's start files.
	 *
	 * @param  string  $path
	 * @return void
	 */
	protected function loadStartFiles($path)
	{
		foreach($this->filesystem->files($path) as $file)
		{
			$this->filesystem->requireOnce($file);
		}
	}

	/**
	 * Load the module's plugin, if it has one.
	 *
	 * @param  string  $path
	 * @return void
	 */
	protected function loadPlugin($path)
	{
		$plugin = ucfirst($this->data->slug).'Plugin';

		// Todo: Dependency injection?
		if(class_exists($plugin))
		{
			Anvil::make('plugins')->register($this->data->slug, $plugin);
		}

		Anvil::make('view')->addNamespace($this->data->slug, $path.'views');
	}

	/**
	 * Find the module's existing directories.
	 *
	 * @param  string  $path
	 * @return array
	 */
	protected function getExistingDirectories($path)
	{
		// All of the module's directories are optional. So, let's find the
		// directories that the module does have.
		$directories = array_filter($this->directories, function($directory) use ($path)
		{
			return is_dir($path.$directory);
		});
	}
}