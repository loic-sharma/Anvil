<?php

class TemplatePlugin extends Plugin {

	/**
	 * The URL to the template's directory.
	 *
	 * @var string
	 */
	protected $templateUrl;

	/**
	 * The different supported asset types.
	 *
	 * @var array
	 */
	protected $assetTypes = array('css', 'js');

	/**
	 * The registered assets.
	 *
	 * @var array
	 */
	protected $assets = array();

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
	 * Add an asset.
	 *
	 * @param  string  $asset
	 * @param  string  $url
	 * @return void
	 */
	public function addAsset($assetType, $url)
	{
		if( ! isset($this->assets[$assetType]))
		{
			if(in_array($assetType, $this->assetTypes))
			{
				$this->assets[$assetType] = array();				
			}

			else
			{
				throw new InvalidArgumentException;
			}
		}

		$this->assets[$assetType][] = $url;
	}

	/**
	 * Fetch the assets.
	 *
	 * @param  string  $asset
	 * @return string
	 */
	public function assets($asset)
	{
		$output = '';

		if(isset($this->assets[$asset]))
		{
			foreach($this->assets[$asset] as $data)
			{
				if( ! empty($output))
				{
					$output .= PHP_EOL;
				}

				$output .= $this->$asset($data);
			}
		}

		return $output;
	}

	/**
	 * Fetch the asset's path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	protected function path($path)
	{
		if(strpos($path, 'path: ') === 0)
		{
			return $path;
		}

		else
		{
			return $this->templateUrl.'/'.$path;
		}
	}

	/**
	 * Generate the HTML to load a CSS file from the current theme.
	 *
	 * @param  string  $file
	 * @return string
	 */
	public function css($file)
	{
		return '<link href="'.$this->path($file).'" rel="stylesheet" type="text/css" />';
	}

	/**
	 * Generate the HTML to load a JS file from the current theme.
	 *
	 * @param  string  $file
	 * @return string
	 */
	public function js($file)
	{
		return '<script src="'.$this->path($file).'" type="text/javascript"></script>';
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
	 * Load a template partial.
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