<?php

class PagePlugin {

	public $layout = 'layouts.default';

	public $template;
	public $title;
	public $breadcrumbs = array();
	public $content;

	public function __construct()
	{
		$this->template = Settings::get('template');
		$this->title = Settings::get('title');

		$this->addBreadcrumb('Home', '/');
	}

	public function addBreadcrumb($name, $link = null)
	{
		if( ! is_null($link))
		{
			if(strpos($link, '.') === false)
			{
				$link = ($link == '/') ? URL::base() : URL::to($link);
			}
		}

		$this->breadcrumbs[] = (object) compact('name', 'link');
	}

	public function setContent($view, $data = array())
	{
		$this->content = View::make($view, $data);
	}

	public function render()
	{
		if(file_exists('templates/'.$this->template.'/bootstrap.php'))
		{
			include 'templates/'.$this->template.'/bootstrap.php';
		}

		return View::make($this->layout);
	}

	public function title()
	{
		return $this->title;
	}

	public function content()
	{
		return $this->content;
	}

	public function isHome()
	{
		return App::make('controller.router')->isHome();
	}

	public function hasBreadcrumbs()
	{
		return ! empty($this->breadcrumbs);
	}

	public function breadcrumbs()
	{
		return $this->breadcrumbs;
	}

	public function loadTime()
	{
		return round(microtime(true) - CMS_START, 4);
	}
}