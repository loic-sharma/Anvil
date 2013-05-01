<?php namespace Anvil\Modules;

use Anvil;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Composer\Autoload\ClassLoader;

class Repository extends Collection {

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
	public function __construct(Filesystem $filesystem,
                                ClassLoader $autoloader,
                                LoaderInterface $loader,
                                $path)
	{
		$this->filesystem = $filesystem;
		$this->autoloader = $autoloader;
		$this->modules = $loader->get();
		$this->path = $path;

		parent::__construct($this->modules);
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
		// We will return the directory in which the modules are
		// stored if we weren't given the name to a specific module.
		if(is_null($module))
		{
			return $this->path;
		}

		else
		{
			return $this->path.'/'.$module.'/';
		}
	}

	/**
	 * Verify if that a module exists.
	 *
	 * @param  string  $module
	 * @return bool
	 */
	public function exists($module)
	{
		// First, let's check if a module with that name has already
		// been booted.
		if(in_array($module, $this->booted))
		{
			return true;
		}

		// If not, let's check if there is a directory that matches
		// the module's name.
		return $this->filesystem->isDirectory($this->getPath($module));
	}

	/**
	 * Boot all of the modules.
	 *
	 * @return void
	 */
	public function boot()
	{
		foreach($this->modules as $module)
		{
			$module->boot();
		}
	}
}