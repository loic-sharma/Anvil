<?php

use Blog\PostService;

class BlogPlugin extends Plugin {

	protected $postService;

	public function __construct(PostService $postService)
	{
		$this->postService = $postService;
	}

	public function posts(array $options = array())
	{
		$limit    = $this->attribute($options, 'limit', 10);
		$offset   = $this->attribute($options, 'offset', 0);
		$orderBy  = $this->attribute($options, 'order-by', 'created_at');
		$orderDir = $this->attribute($options, 'order-dir', 'ASC');

		/*
			return $this->post
				->with('author')
				->orderBy($orderBy, $orderDir)
				->skip($offset)
				->take($limit)
				->get();
		*/

		return $this->postService->getPosts();
	}
}