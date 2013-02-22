<?php namespace Anvil\Auth\Models;

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
	 * The model's validation rules.
	 *
	 * @var array
	 */
	protected $rules = array(
		'name'  => array('required'),
		'power' => array('required', 'numeric'),
	);

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
		return $this->hasMany('Anvil\Auth\Models\User');
	}

	/**
	 * Get the group's permissions.
	 *
	 * @return array
	 */
	public function getPermissionsAttribute()
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
	 * Verify that the group has a certain permission.
	 *
	 * @param  string  $action
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

	/**
	 * Verify that the group does not have a certain permission.
	 *
	 * @param  string  $action
	 * @return bool
	 */
	public function cannot($action)
	{
		return ! $this->can($action);
	}
}