<?php

use Blog\Post;

class BlogController extends Controller {

	public function getIndex()
	{
		$posts = Post::all();

		$this->page->addBreadcrumb('Blog');

		$this->page->setContent('blog::posts', compact('posts'));
	}

	public function getPost($id)
	{
		$post = Post::find($id);

		if(is_null($post))
		{
			throw new HttpNotFoundException;
		}

		$this->page->addBreadcrumb('Blog', 'blog');
		$this->page->addBreadcrumb('Post');

		$this->page->setContent('blog::post', compact('post'));
	}
}