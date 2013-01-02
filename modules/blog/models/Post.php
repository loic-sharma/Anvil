<?php

namespace Blog;

use URL;
use Eloquent;

class Post extends Eloquent {

	public $table = 'posts';
	public $timestamps = true;

	public function author()
	{
		return $this->belongsTo('User');
	}

	public function comments()
	{
		return $this->hasMany('Blog\Comment');
	}

	public function date()
	{
		return $this->attributes['created_at'];
	}

	public function url()
	{
		return Url::to('blog/post/'.$this->attributes['id']);
	}
}