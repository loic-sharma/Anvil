<?php

class ThemesPlugin {

	public function getPaths()
	{
		$path = App::make('themes.path');

		return glob($path.'/*');
	}

	/**
	 * Get all of the available templates.
	 *
	 * @return array
	 */
	public function get()
	{
		$themePath = App::make('themes.path');
		$themes = array();

		foreach($this->getPaths() as $path)
		{
			if(is_dir($path) and file_exists($path.'/theme.php'))
			{
				include $path.'/theme.php';

				$theme = str_replace($themePath.'/', '', $path);
				$theme = ucfirst($theme.'Theme');

				$themes[] = new $theme;
			}
		}

		return $themes;
	}
}