<?php

use Blog\Post;
use Blog\Comment;

class BlogController extends Controller {

	/**
	 * Display all of the blog posts.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$posts = Post::orderBy('created_at', 'desc')->get();

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
		if(Auth::user()->can('post_comment'))
		{
			$post = Post::find($id);

			if( ! is_null($post))
			{
				$comment = new Comment;

				$comment->author_id = Auth::user()->id;
				$comment->post_id   = $id;
				$comment->content   = Input::get('comment');

				if($comment->save())
				{
					return Redirect::to('blog/post/'.$id);
				}

				else
				{
					$errors = $comment->errors();
				}
			}

			else
			{
				$errors = new MessageBag;

				$errors->add('post', 'Post does not exist.');
			}
		}

		else
		{
			$errors = new MessageBag;

			$errors->add('user', 'User cannot create new comments.');
		}

		return Redirect::back()->withInput()->withErrors($errors);
	}
}