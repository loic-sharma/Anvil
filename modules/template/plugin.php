<?php

class TemplatePlugin extends Plugin {

	protected $templateUrl;

	public function __construct()
	{
		$this->templateUrl  = URL::base().'templates/';
		$this->templateUrl .= Settings::get('template');
	}

	public function options()
	{
		var_dump($this->attributes());
	}

	public function option()
	{
		// @todo
		return 'option method from template plugin';
	}

	public function css($file)
	{
		return '<link href="'.$this->templateUrl.'/css/'.$file.'" rel="stylesheet" type="text/css" />';
	}

	public function image($options)
	{
		$file = $this->attribute($options, 'file', null);

		if( ! is_null($file))
		{
			return '<link href="'.$this->templateUrl.'/img/'.$file.'" rel="shortcut icon" type="image/x-icon" />';
		}
	}

	public function js($file)
	{
		return '<link href="'.$this->templateUrl.'/img/'.$file.'" rel="shortcut icon" type="image/x-icon" />';
	}

	public function favicon($file)
	{
		return '<link href="'.$this->templateUrl.'/img/'.$file.'" rel="shortcut icon" type="image/x-icon" />';
	}

	public function metadata()
	{

	}

	public function partial($view)
	{
		return View::make('partials.'.$view);
	}
}