<?php

class PagePlugin {

	/**
	 * The current template layout.
	 *
	 * @var string
	 */
	public $layout = 'layouts.default';

	/**
	 * The current template.
	 *
	 * @var string
	 */
	public $template;

	/**
	 * The page's title.
	 *
	 * @var string
	 */
	public $title;

	/**
	 * The page's breadcrumbs
	 *
	 * @var array
	 */
	public $breadcrumbs = array();

	/**
	 * The page's content.
	 *
	 * @var string
	 */
	public $content;

	/**
	 * Get the page's settings.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->template = Settings::get('template');
		$this->title = Settings::get('title');

		$this->addBreadcrumb('Home', '/');
	}

	/**
	 * Add a breadcrumb to the page.
	 *
	 * @param  string  $name
	 * @param  string  $link
	 * @return void
	 */
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

	/**
	 * Set the page's content.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return void
	 */
	public function setContent($view, $data = array())
	{
		$this->content = View::make($view, $data);
	}

	/**
	 * Render the page.
	 *
	 * @return string
	 */
	public function render()
	{
		$path = App::make('template.path');

		if(file_exists($path.'/start.php'))
		{
			include $path.'/start.php';
		}

		return View::make($this->layout);
	}

	/**
	 * Fetch the page's title.
	 *
	 * @return string
	 */
	public function title()
	{
		return $this->title;
	}

	/**
	 * Fetch the page's content.
	 *
	 * @return string
	 */
	public function content()
	{
		return $this->content;
	}

	/**
	 * Determine if the current page is the home page.
	 *
	 * @return bool
	 */
	public function isHome()
	{
		return App::make('controller.router')->isHome();
	}

	/**
	 * Determine if the current page has breadcrumbs.
	 *
	 * @return bool
	 */
	public function hasBreadcrumbs()
	{
		return ! empty($this->breadcrumbs);
	}

	/**
	 * Fetch the page's breadcrumbs.
	 *
	 * @return array
	 */
	public function breadcrumbs()
	{
		return $this->breadcrumbs;
	}

	/**
	 * Fetch the page's load time.
	 *
	 * @return double
	 */
	public function loadTime()
	{
		return round(microtime(true) - CMS_START, 4);
	}
}