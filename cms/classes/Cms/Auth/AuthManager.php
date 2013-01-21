<?php namespace Cms\Auth;

use Cms\Auth\Models\User;
use Cms\Auth\Models\Group;
use Illuminate\Auth\AuthManager as IlluminateAuthManager;

class AuthManager extends IlluminateAuthManager {

	/**
	 * Determine if the current user is authenticated.
	 *
	 * @return bool
	 */
	public function check()
	{
		return ($this->user()->group->power > 0);
	}

	/**
	 * Determine if the current user is a guest.
	 *
	 * @return bool
	 */
	public function guest()
	{
		return ($this->user()->group->power <= 0);
	}

	/**
	 * Get the currently authenticated user.
	 *
	 * @return Illuminate\Auth\UserInterface|null
	 */
	public function user()
	{
		$user = $this->driver()->user();

		if(is_null($user))
		{
			$user = new User;

			$user->group = Group::where('name', 'guest')->first();
		}

		return $user;
	}
}