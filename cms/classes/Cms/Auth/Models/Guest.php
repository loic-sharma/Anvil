<?php namespace Cms\Auth\Models;

use Illuminate\Auth\UserInterface;

class Guest extends User implements UserInterface {

	/**
	 * Get the Guest group.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->group = Group::where('name', 'guest')
							->orWhere('power', 0)
							->first();
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
	public function displayName()
	{
		return 'Guest';
	}

	/**
	 * Get the date the user registered.
	 *
	 * @return string
	 */
	public function date()
	{
		return 'Never';
	}

	/**
	 * Get the default gravatar URL.
	 *
	 * @return string
	 */
	public function gravatarUrl($size = 60)
	{
		return 'http://www.gravatar.com/avatar/00000000000000000000000000000000?s='.$size;
	}
}