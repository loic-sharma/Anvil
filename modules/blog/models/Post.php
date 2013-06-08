<?php namespace Blog;

use URL;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

class Post extends Eloquent {

	/**
	 * The model's table name.
	 *
	 * @var string
	 */
	public $table = 'posts';

	/**
	 * The model's validation rules.
	 *
	 * @var array
	 */
	public $rules = array(
		'author_id'        => array('required', 'numeric'),
		'title'            => array('required'),
		'content'          => array('required'),
		'comments_enabled' => array('integer'),
	);

	/**
	 * Wether the table keeps track of timestamps.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Get the newest posts.
	 *
	 * @param  \Illuminate\Database\ELoquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeNewest(Builder $query)
	{
		return $query->orderBy('created_at', 'desc');
	}

	/**
	 * Get the oldest posts.
	 *
	 * @param  \Illuminate\Database\ELoquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOldest(Builder $query)
	{
		return $query->orderBy('created_at', 'asc');
	}

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Get the post's comments.
	 *
	 */
	public function comments()
	{
		return $this->hasMany('Comment')->where('area', 'blog-post-'.$this->attributes['id']);
	}

	/**
	 * Get wether the comments are enabled for the post.
	 *
	 * @return bool
	 */
	public function getCommentsEnabledAttribute()
	{
		return $this->attributes['comments_enabled'];
	}

	/**
	 * Get the date the post was created.
	 *
	 * @return string
	 */ 
	public function getTimeAgoAttribute()
	{
		return $this->created_at->diffForHumans();
	}

	/**
	 * Get the URL to the post.
	 *
	 * @return string
	 */
	public function getUrlAttribute()
	{
		return Url::to('blog/post/'.$this->attributes['id']);
	}
}