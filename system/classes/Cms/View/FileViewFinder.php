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

	protected $extensions = array('php', 'blade.php');

	public function __construct(Filesystem $files, Settings $settings)
	{
		$this->files = $files;

		$this->templatePath = App::make('path.base').'/templates/'.$settings->get('template').'/views/';
	}

	public function setTemplatePath($path)
	{
		$this->templatePath = rtrim($path, '/').'/';
	}

	public function setModulePath($path)
	{
		$this->modulePath = rtrim($path, '/').'/';
	}

	public function find($name)
	{
		list($module, $name) = $this->prepare($name);

		return $this->findInPaths($name, $this->generatePaths($module));
	}

	protected function prepare($name)
	{
		$module = null;

		if(strpos($name, '::') !== false)
		{
			list($module, $name) = explode('::', $name);
		}

		return array($module, $name);
	}

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

	public function addLocation($location)
	{
		$this->paths[] = $location;
	}

	public function addNamespace($namespace, $hint) {}
}
