<?php

namespace Cms\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	/**
	 * The table's name.
	 *
	 * @var string
	 */
	public $table = 'groups';

	/**
	 * Get all of the group's users.
	 *
	 */
	public function users()
	{
		return $this->hasMany('Cms\Auth\Models\User');
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
	 * Verify if the group has a certain permission.
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
			return false;
		}
	}
}