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
		'content' => 'required',
	);

}