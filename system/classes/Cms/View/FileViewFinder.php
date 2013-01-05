<?php

namespace Cms\View;

use App;
use Illuminate\Filesystem;
use Illuminate\View\FileViewFinder as IlluminateViewFinder;
use Cms\Settings\Repository as Settings;

class FileViewFinder extends IlluminateViewFinder {

	protected $files;

	protected $paths = array();
	protected $templatePath;
	protected $modulePath;

	/**
	 * The extensions recognized by the View Finder.
	 *
	 * @var array
	 */
	protected $extensions = array('php', 'blade.php');

	/**
	 * Create a new instance.
	 *
	 * @param  Filesystem  $files
	 * @param  Settings    $settings
	 * @return void
	 */
	public function __construct(Filesystem $files, Settings $settings)
	{
		$this->files = $files;

		$this->templatePath = App::make('path.base').'/templates/'.$settings->get('template').'/views/';
	}

	/**
	 * Set the current template path.
	 *
	 * @param  string  $path
	 * @return void
	 */
	public function setTemplatePath($path)
	{
		$this->templatePath = rtrim($path, '/').'/';
	}

	/**
	 * Set the module path.
	 *
	 * @param  string  $path
	 * @return void
	 */
	public function setModulePath($path)
	{
		$this->modulePath = rtrim($path, '/').'/';
	}

	/**
	 * Find a view.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function find($name)
	{
		list($module, $name) = $this->prepare($name);

		return $this->findInPaths($name, $this->generatePaths($module));
	}

	/**
	 * Separate the module's and view's name.
	 *
	 * @param  string  $name
	 * @return array
	 */
	protected function prepare($name)
	{
		$module = null;

		if(strpos($name, '::') !== false)
		{
			list($module, $name) = explode('::', $name);
		}

		return array($module, $name);
	}

	/**
	 * Generate all of the possible view paths for a module.
	 *
	 * @param  string  $module
	 * @return array
	 */
	protected function generatePaths($module)
	{
		$paths = $this->paths;

		array_unshift($paths, $this->templatePath);

		if( ! is_null($module))
		{
			$paths[0] .= 'partials/'.$module;
			$paths[]   = $this->modulePath.$module.'/views';
		}

		return $paths;
	}

	/**
	 * Add a path to the view finder.
	 *
	 * @param  string  $location
	 * @return void
	 */
	public function addLocation($location)
	{
		$this->paths[] = $location;
	}

	public function addNamespace($namespace, $hint) {}
}
