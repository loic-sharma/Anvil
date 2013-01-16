<?php

namespace Navigation;

use Eloquent;

class Group extends Eloquent {

	/**
	 * The model's table.
	 *
	 * @var string
	 */
	public $table = 'navigation_groups';

	/**
	 * Wether the table timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the navigation group's links.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function links()
	{
		return $this->hasMany('Navigation\Link');
	}
}