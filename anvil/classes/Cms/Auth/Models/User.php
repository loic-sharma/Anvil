<?php namespace Cms\Auth\Models;

use Hash;
use ExpressiveDate;
use Cms\Database\Eloquent;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {

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
	protected $hidden = array('password');

	/**
	 * The model's validation rules.
	 *
	 * @var array
	 */
	public $rules = array(
		'email'      => array('required', 'email', 'unique:users'),
		'password'   => array('required', 'confirmed'),
		'first_name' => array('alpha_dash'),
		'last_name'  => array('alpha_dash'),
		'group_id'   => array('required', 'numeric'),
	);

	/**
	 * The fields to hash before saving.
	 *
	 * @var array
	 */
	public $hash = array('password');

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
	 * Get the user's power.
	 *
	 */
	public function getPowerAttribute()
	{
		return $this->group->power;
	}

	/**
	 * Check if a user belongs to a certain group.
	 *
	 * @param  string|int  $group
	 * @return bool
	 */
	public function is($group)
	{
		if(is_int($group))
		{
			return $this->group->id = $group;
		}

		else
		{
			return $this->group->name = $group;
		}
	}

	/**
	 * Get the group's permission.
	 *
	 */
	public function getPermissonsAttribute($permissions)
	{
		return $this->group->getPermissions($permissions);
	}


	/**
	 * Verify that a user has a certain permission.
	 *
	 * @param  string  $permission
	 * @return bool
	 */
	public function can($permission)
	{
		return $this->group->can($permission);
	}

	/**
	 * Verify that a user does not have a certain permission.
	 *
	 * @param  string  $permission
	 * @return bool
	 */
	public function cannot($permission)
	{
		return ! $this->can($permission);
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