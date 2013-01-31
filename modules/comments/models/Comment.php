<?php

class Comment extends Eloquent {

	/**
	 * The model's table name.
	 *
	 * @var string
	 */
	public $table = 'comments';

	/**
	 * Wether the table keeps track of timestamps.
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
		'area'      => 'required',
		'author_id' => 'required',
		'content'   => 'required',
	);

	/**
	 * Get the name of the area the comment belongs to.
	 *
	 * @return string
	 */
	public function giveAreaName()
	{
		$name = str_replace('-', ' ', $this->attributes['area']);

		return ucwords($name);
	}

	/**
	 * Get the link to the comment's area.
	 *
	 * @return string
	 */
	public function giveAreaLink()
	{
		return Url::to(str_replace('-', '/', $this->attributes['area']));
	}

	/**
	 * Get the date the post was created.
	 *
	 * @return string
	 */
	public function giveDate()
	{
		return $this->attributes['created_at'];
	}

	/**
	 * Get the expressive date for the comment's creation date.
	 *
	 * @return string
	 */
	public function date()
	{
		return ExpressiveDate::make($this->getDate())->getRelativeDate();
	}

	/**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function giveContent()
	{
		return nl2br($this->attributes['content']);
	}

	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User');
	}
}