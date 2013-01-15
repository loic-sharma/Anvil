<?php

class TemplatePlugin extends Plugin {

	/**
	 * The URL to the template's directory.
	 *
	 * @var string
	 */
	protected $templateUrl;

	/**
	 * Set the default template.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->setTemplate(Settings::get('template'));
	}

	/**
	 * Set the plugin's template.
	 *
	 * @param  string  $template
	 * @return void
	 */
	public function setTemplate($template)
	{
		$this->templateUrl = URL::base().'templates/'.$template;
	}

	/**
	 * Generate the HTML to load a CSS file from the current theme.
	 *
	 * @param  string  $file
	 * @return string
	 */
	public function css($file)
	{
		return '<link href="'.$this->templateUrl.'/css/'.$file.'" rel="stylesheet" type="text/css" />';
	}

	/**
	 * Generate the HTML to load a JS file from the current theme.
	 *
	 * @param  string  $file
	 * @return string
	 */
	public function js($file)
	{
		return '<script src="'.$this->templateUrl.'/js/'.$file.'" type="text/javascript"></script>';
	}

	/**
	 * Generate the HTML to load a favicon file from the current theme.
	 *
	 * @param  string  $file
	 * @return string
	 */
	public function favicon($file)
	{
		return '<link href="'.$this->templateUrl.'/img/'.$file.'.ico" rel="shortcut icon" type="image/x-icon" />';
	}

	/**
	 * Load a template partial.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return string
	 */
	public function partial($view, array $data = array())
	{
		return View::make('partials.'.$view, $data);
	}
}