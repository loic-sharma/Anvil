<?php namespace Anvil\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	/**
	 * The table's name.
	 *
	 * @var string
	 */
	public $table = 'permissions';

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
	public $rules = array(
		'name'           => 'required',
		'slug'           => 'required',
		'required_power' => 'numeric',
		'max_power'      => 'numeric',
	);	
}