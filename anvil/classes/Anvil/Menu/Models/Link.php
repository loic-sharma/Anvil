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
		if($url == '/' or $url == '{url}/')
		{
			return URL::base();
		}

		else
		{
			if(strpos($url, '{url}/') === 0)
			{
				return URL::to(substr($url, 6));
			}

			else
			{
				if(strpos($url, '{adminUrl}/') === 0)
				{
					return URL::to('admin/'.substr($url, 11));
				}

				else
				{
					return $url;
				}
			}
		}
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