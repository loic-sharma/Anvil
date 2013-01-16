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
		$path = App::make('templates.path');

		return array_map(function($template) use($path)
		{
			return str_replace($path.'/', '', $template);
		}, $this->getPaths());
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