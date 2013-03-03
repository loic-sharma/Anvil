<?php namespace Anvil\Modules;

use Anvil;

class Module {

	/**
	 * The module's data.
	 *
	 * @var array
	 */
	protected $data;

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
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Fetch the module's path.
	 *
	 * @return string
	 */
	public function getPath()
	{
		return Anvil::make('module.path').'/'.$this->data->slug.'/';
	}

	/**
	 * Boot the module.
	 *
	 * @return void
	 */
	public function boot()
	{
		if(is_dir($path = $this->getPath()))
		{
			// Add the module's controller and model directories (if they exist)
			// to the autoloader's list of directories.
			$directories = array($path.'controllers', $path.'models');

			$directories = array_filter($directories, function($directory)
			{
				return is_dir($directory);
			});

			Anvil::make('autoloader')->add(null, $directories);
			Anvil::make('autoloader')->add(ucfirst($this->data->slug), $path.'classes');

			// Load the module's start files.
			foreach(Anvil::make('files')->files($path) as $file)
			{
				Anvil::make('files')->requireOnce($file);
			}

			$plugin = ucfirst($this->data->slug).'Plugin';

			// Todo: Dependency injection?
			if(class_exists($plugin))
			{
				Anvil::make('plugins')->register($this->data->slug, $plugin);
			}

			Anvil::make('view')->addNamespace($this->data->slug, $path.'views');
		}

		else
		{
			throw new \InvalidArgumentException("Module [$module] does not exist.");
		}
	}
}