<?php

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
	 * Show the form to create a new blog post.
	 *
	 * @return void
	 */
	public function getCreatePost()
	{
		$post = new Post;

		// By default we'll enable comments.
		$post->commentsEnabled = true;

		$this->page->addBreadcrumb('Blog')->to('admin/blog');
		$this->page->addBreadcrumb('Create Post');

		$this->page->setContent('blog::admin.post', compact('post'));
	}

	/**
	 * Create a new blog post.
	 *
	 * @return void
	 */ 
	public function postCreatePost()
	{
		$post = new Post;

		$post->author_id = Auth::user()->id;
		$post->title = Input::get('title');
		$post->content = Input::get('content');
		$post->commentsEnabled = Input::get('comments_enabled', 0);

		if($post->save())
		{
			$message  = 'Successfully created post. ';
			$message .= '<a href="'.Url::to('blog/post/'.$post->id).'">View post</a>';

			return Redirect::to('admin/blog/post/'.$post->id)
					->with('message', $message);
		}

		else
		{
			return Redirect::back()
					->withInput()
					->withErrors($post->errors());
		}
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

		$this->page->addBreadcrumb('Blog')->to('admin/blog');
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
		$post = Post::find($id);

		if( ! is_null($post))
		{
			$post->title   = Input::get('title');
			$post->content = Input::get('content');
			$post->comments_enabled = Input::get('comments_enabled', 0);

			if($post->save())
			{
				$message  = 'Successfully edited post. ';
				$message .= '<a href="'.Url::to('blog/post/'.$post->id).'">View post</a>';

				return Redirect::to('admin/blog/post/'.$id)
					->with('message', $message);
			}

			else
			{
				$errors = $post->errors();
			}
		}

		else
		{
			$errors = 'Post does not exist.';
		}

		return Redirect::back()
				->withInput()
				->withErrors($errors);
	}

	/**
	 * Delete a post.
	 *
	 * @param  int  $id
	 * @return Illuminate\Http\RedirectResponse
	 */
	public function getDeletePost($id)
	{
		$post = Post::find($id);

		if( ! is_null($post))
		{
			$post->delete();

			return Redirect::to('admin/blog')
					->with('message', 'Successfully deleted post.');
		}

		else
		{
			$errors = 'Post does not exist.';
		}

		return Redirect::back()->withErrors($errors);
	}
}