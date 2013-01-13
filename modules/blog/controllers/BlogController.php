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
			'comment' => 'required'
		));

		if($form->passes())
		{
			$post = Post::find($id);

			if( ! is_null($post))
			{
				$comment = new Comment;

				$comment->author_id = Auth::user()->id;
				$comment->post_id   = $id;
				$comment->content   = Input::get('comment');

				$comment->save();

				return Redirect::to('blog/post/'.$id);
			}

			else
			{
				$errors = new MessageBag;

				$errors->add('post', 'Post does not exist.');
			}
		}

		else
		{
			$errors = $form->messages();
		}

		Input::flash();

		return Redirect::back()->withErrors($errors);

	}
}