<?php

class TemplatesPlugin {

	public function getPaths()
	{
		$path = App::make('templates.path');

		return glob($path.'/*');
	}

	/**
	 * Get all of the available templates.
	 *
	 * @return array
	 */
	public function get()
	{
		$themePath = App::make('templates.path');
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

	/**
	 * Get all of the templates. They keys are the template's
	 * slug and the values are the template's name.
	 *
	 * @return array
	 */
	public function getAssociative()
	{
		$path = App::make('templates.path');
		$templates = array();

		foreach($this->get() as $slug)
		{
			$template = ucfirst(str_replace('_', ' ', $slug));

			$templates[$slug] = $template;
		}

		return $templates;
	}
}