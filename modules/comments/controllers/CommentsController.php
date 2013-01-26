<?php

class CommentsController extends Controller {

	public function postPost()
	{
		if(Auth::user()->can('post_comment'))
		{
			$comment = new Comment;

			$comment->author_id = Auth::user()->id;
			$comment->area      = Input::get('area');
			$comment->content   = Input::get('content');

			if($comment->save())
			{
				return Redirect::back();
			}

			else
			{
				$errors = $comment->errors();
			}
		}

		else
		{
			$errors = new MessageBag(array(
				'user' => 'User cannot create new comments.'
			));
		}

		return Redirect::back()->withInput()->withErrors($errors);
	}
}