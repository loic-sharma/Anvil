<?php namespace Cms\Auth\Models;

use Hash;
use ExpressiveDate;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements UserInterface {

	/**
	 * The table's name.
	 *
	 * @var string
	 */
	public $table = 'users';

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = array(
		'password',
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->attributes['id'];
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->attributes['password'];
	}

	/**
	 * Get the user's group.
	 *
	 */
	public function group()
	{
		return $this->belongsTo('Cms\Auth\Models\Group');
	}

	/**
	 * Set the groups's permissions.
	 *
	 * @param  array  $permissions
	 * @return void
	 */
	public function setPermissions($permissions)
	{
		$this->attributes['permissions'] = json_encode($permissions);
	}

	/**
	 * Get the group's permission.
	 *
	 */
	public function getPermissions($permissions)
	{
		if (is_null($permissions))
		{
			return array();
		}

		if (is_array($permissions))
		{
			return $permissions;
		}

		if ( ! $_permissions = json_decode($permissions, true))
		{
			throw new \InvalidArgumentException("Cannot JSON decode permissions [$permissions].");
		}

		return $_permissions;
	}

	/**
	 * Automatically hash the password when it is set.
	 *
	 * @param  string  $password
	 * @return void
	 */
	public function setPassword($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	/**
	 * Verify a user has a certain permission.
	 *
	 * @param  string  $permission
	 * @return bool
	 */
	public function can($permission)
	{
		if(isset($this->permissions[$permission]))
		{
			return $this->permissions[$permission];
		}

		else
		{
			return $this->group->can($permission);
		}
	}

	/**
	 * Get the display name for the user.
	 *
	 * @return string
	 */
	public function displayName()
	{
		return $this->attributes['first_name'].' '.$this->attributes['last_name'];
	}

	/**
	 * Get the date the user registered.
	 *
	 * @return string
	 */
	public function date()
	{
		$date = new ExpressiveDate($this->attributes['created_at']);

		return $date->getRelativeDate();
	}

	/**
	 * Get the gravatar URL for the user.
	 *
	 * @return string
	 */
	public function gravatarUrl($size = 60)
	{
		$url  = 'http://www.gravatar.com/avatar/';
		$url .= md5(strtolower($this->attributes['email']));
		$url .= '?s='.$size;

		return $url;
	}

	/**
	 * Build the gravatar image for the user.
	 *
	 * @return string
	 */
	public function gravatar($size = 60)
	{
		$url = $this->gravatarUrl($size);

		return '<img src="'.$url.'" alt="Gravatar" class="gravatar" />';
	}
}