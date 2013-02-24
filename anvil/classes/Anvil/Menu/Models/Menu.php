<?php namespace Anvil\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

	/**
	 * The model's table.
	 *
	 * @var string
	 */
	public $table = 'navigation_menus';

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
		'title' => 'required',
		'slug'  => 'required',
	);

	/**
	 * Get the navigation group's links.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function links()
	{
		return $this->hasMany('Anvil\Menu\Models\Link');
	}
}