<?php

namespace Blog;

use Eloquent;

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
	 * Get the date the post was created.
	 *
	 * @return string
	 */
	public function getDate()
	{
		return $this->attributes['created_at'];
	}

	public function date()
	{
		return $this->attributes['created_at'];
	}

	/**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function getContent()
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

	/**
	 *  Get the comment's post.
	 *
	 * @return Blog\Post
	 */
	public function post()
	{
		return $this->belongsTo('Blog\Post');
	}
}