<?php

namespace Navigation;

use Url;
use Eloquent;

class Link extends Eloquent {

	public $table = 'navigation_links';

	public function getUrl($url)
	{
		if($url == '/' || $url == '{url}/')
		{
			return Url::base();
		}

		elseif(strpos($url, '{url}/') === 0)
		{
			return Url::to(substr($url, 6));
		}

		else
		{
			return $url;
		}
	}

	public function group()
	{
		return $this->belongsTo('Navigation\Group');
	}
}