<?php

use Blog\Post;

class BlogController extends Controller {

	/**
	 * Display all of the blog posts.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$posts = Post::all();

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
		$post = Post::find($id);

		if(is_null($post))
		{
			throw new HttpNotFoundException;
		}

		$this->page->addBreadcrumb('Blog', 'blog');
		$this->page->addBreadcrumb('Post');

		$this->page->setContent('blog::post', compact('post'));
	}

	/**
	 * Submit a new blog comment.
	 *
	 * @param  int  $id
	 * @return void
	 */
	public function postPost($id)
	{
		$form = Validator::make(Input::all(), array(
		));
	}
}