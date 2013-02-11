<?php namespace Page;

use Url;

class Breadcrumb {

	/**
	 * The name of the breacrumb.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The link of the breadcrumb.
	 *
	 * @var string
	 */
	public $link;

	/**
	 * Register the name and link of the breadcrumb.
	 *
	 * @param  string  $name
	 * @param  string  $link
	 * @return void
	 */
	public function __construct($name, $link = null)
	{
		$this->name = $name;
		$this->link = $link;
	}

	/**
	 * Fetch the breadcrumb's name.
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}

	/**
	 * Check if the breadcrumb has a link.
	 *
	 * @return bool
	 */
	public function hasLink()
	{
		return ! is_null($this->link);
	}

	/**
	 * Fetch the breadcrumb's link.
	 *
	 * @return string
	 */
	public function link()
	{
		if($this->hasLink())
		{
			// If this is a URI let's run it through
			// the URL class.
			if(strpos($this->link, '.') === false)
			{
				if($this->link == '/')
				{
					return URL::base();
				}

				else
				{
					return URL::to($this->link);
				}
			}
		}
	}

	/**
	 * Fetch the breadcrumb's name.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->name();
	}
}