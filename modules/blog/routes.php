<?php

use Blog\PostService;

class BlogController extends Controller {

	protected $postService;

	public function __construct(PostService $postService)
	{
		$this->postService = $postService;
	}

	public function getIndex()
	{
		$posts = $this->postService->getPosts();

		$this->page->addBreadcrumb('Blog');

		$this->page->setContent('blog::posts', compact('posts'));
	}

	public function getPost($id)
	{
		$post = $this->postService->getPostById($id);

		if(is_null($post))
		{
			throw new HttpNotFoundException;
		}

		$this->page->addBreadcrumb('Blog', 'blog');
		$this->page->addBreadcrumb('Post');

		$this->page->setContent('blog::post', compact('post'));
	}
}