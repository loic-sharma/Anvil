<?php namespace Anvil\Auth;

use Anvil\Auth\Models\User;
use Anvil\Auth\Models\Guest;
use Illuminate\Auth\AuthManager as IlluminateAuthManager;

class AuthManager extends IlluminateAuthManager {

	/**
	 * Determine if the current user is authenticated.
	 *
	 * @return bool
	 */
	public function check()
	{
		return ($this->user()->power > 0);
	}

	/**
	 * Determine if the current user is a guest.
	 *
	 * @return bool
	 */
	public function guest()
	{
		return ($this->user()->power <= 0);
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
			$user = new Guest;
		}

		return $user;
	}
}