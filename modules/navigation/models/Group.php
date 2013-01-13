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
	 * Get the navigation group's links.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function links()
	{
		return $this->hasMany('Navigation\Link');
	}
}