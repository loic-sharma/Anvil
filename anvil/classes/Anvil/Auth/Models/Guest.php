<?php namespace Anvil\Auth\Models;

use Illuminate\Auth\UserInterface;

class Guest extends User implements UserInterface {

	/**
	 * Get the user's group.
	 *
	 */
	public function group()
	{
		return $this->belongsTo('Anvil\Auth\Models\Group')
				->where('name', 'guest')
				->orWhere('power', 0);
	}

	/**
	 * Override the default save user method. Guests should
	 * never be saved.
	 * 
	 */
	public function save()
	{
		throw new Exception("Attempting to save a guest.");
	}

	/**
	 * Get the display name for the user.
	 *
	 * @return string
	 */
	public function getDisplayNameAttribute()
	{
		return 'Guest';
	}

	/**
	 * Get the date the user registered.
	 *
	 * @return string
	 */
	public function getDateAttribute()
	{
		return 'Never';
	}

	/**
	 * Get the default gravatar URL.
	 *
	 * @return string
	 */
	public function getGravatarUrlAttribute($size = 60)
	{
		return 'http://www.gravatar.com/avatar/00000000000000000000000000000000?s='.$size;
	}
}