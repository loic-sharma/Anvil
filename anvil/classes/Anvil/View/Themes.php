<?php namespace Anvil\View;

use Anvil\Routing\UrlGenerator as Url;
use Illuminate\Html\HtmlBuilder as Html;
use Illuminate\Filesystem\Filesystem as Files;

class Themes {

	/**
	 * The path to Anvil's themes.
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * The filesystem.
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * The URL generator.
	 *
	 * @var Anvil\Routing\UrlGenerator
	 */
	protected $url;

	/**
	 * The HTML builder.
	 *
	 * @var Illuminate\Html\HtmlBuilder
	 */
	protected $html;

	/**
	 * The current theme.
	 *
	 * @var string
	 */
	protected $currentTheme;

	/**
	 * All of the started themes.
	 *
	 * @var array
	 */
	protected $themes = array();

	/**
	 * Create a new instance.
	 *
	 * @param  string  $path
	 * @param  Illuminate\Filesystem\Filesystem  $files
	 * @param  Anvil\Routing\UrlGenerator  $url
	 * @param  Illuminate\Html\HtmlBuilder  $html
	 * @return void
	 */
	public function __construct($path, Files $files, Url $url, Html $html)
	{
		$this->path  = $path;
		$this->files = $files;
		$this->url   = $url;
		$this->html  = $html;
	}

	/**
	 * Set the theme.
	 *
	 * @param  string  $theme
	 * @return void
	 */
	public function setTheme($theme)
	{
		$this->currentTheme = $theme;
	}

	/**
	 * Get the current theme.
	 *
	 * @return string
	 */
	public function getCurrentTheme()
	{
		return $this->currentTheme;
	}

	/**
	 * Get the instance of the current theme.
	 *
	 * @param  string $theme
	 * @return Anvil\View\Theme
	 */
	public function getTheme($theme = null)
	{
		$theme = $theme ?: $this->getCurrentTheme();

		return $this->themes[$theme];
	}

	/**
	 * Start a theme.
	 *
	 * @param  string  $theme
	 * @return void
	 */
	public function start($theme = null)
	{
		$theme = $theme ?: $this->getCurrentTheme();

		$this->setTheme($theme);

		if( ! isset($this->themes[$theme]))
		{
			$this->themes[$theme] = new Theme($theme, $this->url, $this->html);

			$path = $this->path.'/'.$theme.'/';

			if($this->files->exists($path.'start.php'))
			{
				$this->files->requireOnce($path.'start.php');
			}
		}

		return $this->themes[$theme];
	}
}