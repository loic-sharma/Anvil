<?php

class ThemesPlugin {

	/**
	 * Get the paths to the themes.
	 *
	 * @return array
	 */
	public function getPaths()
	{
		$path = Anvil::make('themes.path');

		return glob($path.'/*');
	}

	/**
	 * Verify that a theme exists.
	 *
	 * @param  string  $theme
	 * @return bool
	 */
	public function exists($theme)
	{
		return is_dir(Anvil::make('themes.path').'/'.$theme.'/');
	}

	/**
	 * Get all of the available templates.
	 *
	 * @return array
	 */
	public function get()
	{
		$themePath = Anvil::make('themes.path');
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