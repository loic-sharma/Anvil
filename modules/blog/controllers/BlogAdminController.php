<?php

use Blog\Post;

class BlogAdminController extends Controller {

	/**
	 * Display the admin home page.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$this->page->addBreadcrumb('Blog');
		$this->page->setContent('blog::admin.home');
	}

	/**
	 * Display the comments.
	 *
	 * @return void
	 */
	public function getComments()
	{
		$this->page->addBreadcrumb('Blog', 'admin/blog');
		$this->page->addBreadcrumb('Comments');

		$this->page->setContent('blog::admin.comments');
	}

	/**
	 * Show the form to edit a post.
	 *
	 * @param  int   $id
	 * @return void
	 */
	public function getPost($id)
	{
		$post = Post::find($id);

		if(is_null($post))
		{
			return Redirect::back();
		}

		$this->page->addBreadcrumb('Blog', 'admin/blog');
		$this->page->addBreadcrumb('Post');

		$this->page->setContent('blog::admin.post', compact('post'));
	}

	/**
	 * Edit a post.
	 *
	 * @param  int   $id
	 * @return Illuminate\Http\RedirectResponse
	 */
	public function postPost($id)
	{
		$form = Validator::make(Input::all(), array(
			'title'   => 'required',
			'content' => 'required',
		));

		if($form->passes())
		{
			$post = Post::find($id);

			if( ! is_null($post))
			{
				$post->title   = Input::get('title');
				$post->content = Input::get('content');

				$post->save();

				return Redirect::to('admin/blog/post/'.$id);
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

		return Redirect::back()->withErrors($errors);
	}
}