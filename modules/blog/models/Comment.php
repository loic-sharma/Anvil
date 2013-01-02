<?php

namespace Blog;

use Eloquent;

class Comment extends Eloquent {

	public $table = 'comments';
	public $timestamps = true;

	public function getDate()
	{
		return $this->attributes['created_at'];
	}

	public function getContent()
	{
		return nl2br($this->attributes['content']);
	}

	public function author()
	{
		return $this->belongsTo('User');
	}

	public function post()
	{
		return $this->belongsTo('Blog\Post');
	}
}