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
		$posts = Post::orderBy('created_at', 'desc')->get();
		$event = Event::fire('posts.get', compact('posts'));

		$this->page->addBreadcrumb('Blog');

		$this->page->setContent('blog::posts', array('posts' => $event->posts));
	}

	/**
	 * Display a single blog post.
	 *
	 * @param  int   $id
	 * @return void
	 */
	public function getPost($id)
	{
		$post  = Post::find($id);
		$event = Event::fire('post.get', compact('post'));

		if(is_null($post))
		{
			throw new HttpNotFoundException;
		}

		$this->page->addBreadcrumb('Blog', 'blog');
		$this->page->addBreadcrumb('Post');

		$this->page->setContent('blog::post', array('post' => $event->post));
	}
}