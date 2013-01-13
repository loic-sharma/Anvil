<?php

class ModulesPlugin {

	/**
	 * Get all of the module's information.
	 *
	 * @return array
	 */
	public function get()
	{
		$modules = array();
		$paths = glob(App::make('module.path').'/*');

		foreach($paths as $path)
		{
			if(file_exists($path.'/module.php'))
			{
				$moduleName = str_replace(App::make('module.path').'/', '', $path);
				$moduleName = ucfirst($moduleName).'Module';

				include $path.'/module.php';

				$modules[] = new $moduleName;
			}
		}

		return $modules;
	}
}