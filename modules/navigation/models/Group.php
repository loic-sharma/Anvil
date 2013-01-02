<?php

namespace Navigation;

use Eloquent;

class Group extends Eloquent {

	public $table = 'navigation_groups';

	public function links()
	{
		return $this->hasMany('Navigation\Link');
	}
}