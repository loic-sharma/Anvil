<?php namespace Anvil\View;

use Anvil\Routing\UrlGenerator as Url;
use Illuminate\Html\HtmlBuilder as Html;

class Theme {

	/**
	 * The name of the theme.
	 *
	 * @var string
	 */
	protected $name;

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
	 * The theme's assets.
	 *
	 * @var array
	 */
	protected $assets = array();

	/**
	 * The synonyms for different asset types.
	 *
	 * @var array
	 */
	protected $synonyms = array(
		'style' => array('css'),
		'script' => array('js'),
	);

	/**
	 * Create a new instance.
	 *
	 * @param  Anvil\Routing\UrlGenerator   $url
	 * @param  Illuminate\Html\HtmlBuilder  $html
	 * @return void
	 */
	public function __construct($name, Url $url, Html $html)
	{
		$this->name = $name;
		$this->url  = $url;
		$this->html = $html;
	}

	/**
	 * Get the URL to the theme's root directory.
	 *
	 * @return string
	 */
	public function url()
	{
		$baseUrl = $this->url->base();
		$theme = $this->name;

		return $baseUrl.'themes/'.$theme;
	}

	/**
	 * Add an asset.
	 *
	 * @param  string  $type
	 * @param  array   $asset
	 */
	public function addAsset($type, $asset)
	{
		$type = $this->getType($type);

		if( ! isset($this->assets[$type]))
		{
			$this->assets[$type] = array();
		}

		$this->assets[$type][] = $asset;
	}

	/**
	 * Get all of the assets of a certain type.
	 *
	 * @param  string  $type
	 * @return string
	 */
	public function assets($type)
	{
		$type = $this->getType($type);

		$assets = '';

		if(isset($this->assets[$type]))
		{
			// Let's loop through each asset and render them
			// using the HTML builder.
			$callback = array($this->html, $type);

			foreach($this->assets[$type] as $asset)
			{
				$asset = $this->prepareAsset($asset);

				$assets .= call_user_func_array($callback, $asset);	
			}
		}

		return $assets;
	}

	/**
	 * Prepare an asset to be displayed.
	 *
	 * @param  array  $asset
	 * @return array
	 */
	protected function prepareAsset(array $asset)
	{
		// The first value of the asset is it's URL relative to the
		// theme's root directory. Let's prepend the theme's URL here.
		if(isset($asset[0]))
		{
			$themeUrl = $this->url();

			$asset[0] = $themeUrl.'/'.$asset[0];
		}

		return $asset;
	}

	/**
	 * Get the concrete name of the asset type.
	 *
	 * @param  string  $type
	 * @return string
	 */
	protected function getType($type)
	{
		foreach($this->synonyms as $concrete => $synonyms)
		{
			if(in_array($type, $synonyms))
			{
				return $concrete;
			}
		}

		return $type;
	}

	/**
	 * Add or fetch an asset.
	 *
	 * @param  string  $method
	 * @param  array   $arguments
	 */
	public function __call($method, $arguments = array())
	{
		if(strpos($method, 'add') === 0)
		{
			$type = strtolower(substr($method, 3));

			return $this->addAsset($type, $arguments);
		}

		else
		{
			return $this->assets($method);
		}
	}
}