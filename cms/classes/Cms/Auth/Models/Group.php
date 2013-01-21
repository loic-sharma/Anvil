<?php namespace Cms\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	/**
	 * The table's name.
	 *
	 * @var string
	 */
	public $table = 'groups';

	/**
	 * Wether the table timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * A cached copy of the groups' permissions.
	 *
	 * @var array
	 */
	protected static $_permissions = array();

	/**
	 * Get all of the group's users.
	 *
	 */
	public function users()
	{
		return $this->hasMany('Cms\Auth\Models\User');
	}

	/**
	 * Get the group's permissions.
	 *
	 *
	 */
	public function getPermissions()
	{
		$name = $this->name;
		$power = $this->power;

		if( ! isset(static::$_permissions[$name]))
		{
			static::$_permissions[$name] = Permission::where(function($query) use($power)
			{
				$query->whereNull('required_power');
				$query->orWhere('required_power', '<=', $power);
			})->where(function($query)
			{
				$query->whereNull('max_power');
				$query->orWhere('max_power', '>=', $this->power);
			})->get();
		}

		return static::$_permissions[$name];
	}

	/**
	 * Verify if the group has a certain permission.
	 *
	 * @param  string  $permission
	 * @return bool
	 */
	public function can($action)
	{
		foreach($this->permissions as $permission)
		{
			if($permission->slug == $action)
			{
				return true;
			}
		}

		return false;
	}
}