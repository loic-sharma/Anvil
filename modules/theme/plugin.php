<?php

class ThemePlugin extends Plugin {

	/**
	 * Fetch the assets.
	 *
	 * @param  string  $asset
	 * @return string
	 */
	public function assets($asset)
	{
		return Theme::assets($asset);
	}

	/**
	 * Generate the HTML to load a favicon file from the current theme.
	 *
	 * @param  string  $file
	 * @return string
	 */
	public function favicon($file)
	{
		return '<link href="'.$this->path($file).'" rel="shortcut icon" type="image/x-icon" />';
	}

	/**
	 * Load a theme partial.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return string
	 */
	public function partial($view, array $data = array())
	{
		return View::make('partials.'.$view, $data)->render();
	}
}