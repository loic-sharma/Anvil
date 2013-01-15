<?php

class TemplatesPlugin {

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
		}, glob($path.'/*'));
	}
}