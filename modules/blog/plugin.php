<?php

use Blog\PostService;

class BlogPlugin extends Plugin {

	protected $postService;

	public function __construct(PostService $postService)
	{
		$this->postService = $postService;
	}

	public function posts($skip = 0, $take = 10, $orderBy = 'created_at', $orderDir = 'ASC')
	{
		return $this->postService->getPosts($skip, $take, $orderBy, $orderDir);
	}
}