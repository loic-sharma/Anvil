<?php

class Page extends Eloquent {

	/**
	 * The model's table name.
	 *
	 * @var string
	 */
	public $table = 'pages';

	/**
	 * Wether the table timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * The model's validation rules.
	 *
	 * @var array
	 */
	public $rules = array(
		'title'   => 'required',
		'slug'    => 'required',
		'content' => 'required',
	);

	/**
	 * Fetch the model's layout.
	 *
	 * @param  string  $layout
	 * @return string
	 */
	public function giveLayout($layout)
	{
		// If the page doesn't have a layout set we'll just
		// use the default layout.
		if(is_null($layout))
		{
			return 'default';
		}

		else
		{
			return $layout;
		}
	}
}