<?php namespace Anvil\Menu\Models;

use URL;
use Illuminate\Database\Eloquent\Model;

class Link extends Model {

	/**
	 * The model's table.
	 *
	 * @var string
	 */
	public $table = 'navigation_links';

	/**
	 * Wether the table timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the model's validation rule.
	 *
	 * @var array
	 */
	public $rules = array(
		'title'          => array('required'),
		'url'            => array('required', 'url'),
		'required_power' => array('numeric'),
	);

	/**
	 * Get the link's URL.
	 *
	 * @param  string  $url
	 * @return string
	 */
	public function getUrlAttribute($url)
	{
		if($url == '/')
		{
			return URL::base();
		}

		else
		{
			// The site's links are "tagged" in the database. The link is prefixed
			// by {url} if the link is for the main site and {adminurl} if the link
			// is for the admin panel. Let's remove the tag now and fetch the full
			// URL for the link.
			$search  = array('{url}/', '{adminUrl}/');
			$replace = array('', 'admin/');

			foreach($search as $key => $needle)
			{
				if(strpos($url, $needle) === 0)
				{
					$url = str_replace($search[$key], $replace[$key], $url);

					return URL::to($url);
				}
			}
		}

		return $url;
	}

	/**
	 * Get the link's required power.
	 *
	 * @return mixed
	 */
	public function requiredPower()
	{
		$requiredPower = $this->attributes['required_power'];

		if(is_null($requiredPower))
		{
			return 'None';
		}

		else
		{
			return $requiredPower;
		}
	}

	/**
	 * Get the link's navigation menu.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function menu()
	{
		return $this->belongsTo('Anvil\Menu\Models\Menu');
	}
}