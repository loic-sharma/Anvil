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
		$paths = glob(Anvil::make('module.path').'/*');

		foreach($paths as $path)
		{
			if(file_exists($path.'/module.php'))
			{
				$moduleName = str_replace(Anvil::make('module.path').'/', '', $path);
				$moduleName = ucfirst($moduleName).'Module';

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