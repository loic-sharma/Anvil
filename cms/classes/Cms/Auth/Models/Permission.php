<?php namespace Cms\Auth\Models;

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
}