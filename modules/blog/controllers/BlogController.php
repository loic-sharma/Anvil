<?php

class BlogController extends Controller {

	/**
	 * Display all of the blog posts.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$posts = Post::newest()->take(5)->get();

		$this->page->addBreadcrumb('Blog');
		$this->page->setContent('blog::posts', compact('posts'));
	}

	/**
	 * Display a single blog post.
	 *
	 * @param  int   $id
	 * @return void
	 */
	public function getPost($id)
	{
		$post = Post::findOrFail($id);

		$this->page->addBreadcrumb('Blog')->to('blog');
		$this->page->addBreadcrumb('Post');

		$this->page->setContent('blog::post', compact('post'));
	}
}