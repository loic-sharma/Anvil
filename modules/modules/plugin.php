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
		$paths = glob(Cms::make('module.path').'/*');

		foreach($paths as $path)
		{
			if(file_exists($path.'/module.php'))
			{
				$moduleName = str_replace(Cms::make('module.path').'/', '', $path);
				$moduleName = ucfirst($moduleName).'Module';

				include $path.'/module.php';

				$module = new $moduleName;

				// These settings are not requrired. If they aren't set,
				// we'll just use false as default.
				foreach(array('hasAdminPanel', 'isCore') as $setting)
				{
					if( ! isset($module->$setting))
					{
						$module->$setting = false;
					}
				}

				$modules[] = $module;
			}
		}

		return $modules;
	}
}