<?php

class CommentsAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Blog')->to('admin/blog');
		$this->page->addBreadcrumb('Comments');

		$this->page->setContent('comments::admin.home');
	}

	/**
	 * Delete a comment.
	 *
	 * @param  int  $id
	 * @return Illuminate\Http\RedirectResponse
	 */
	public function getDelete($id)
	{
		$comment = Comment::find($id);

		if( ! is_null($comment))
		{
			$comment->delete();

			return Redirect::to('admin/comments')
				->with('message', 'Successfully deleted comment.');
		}

		else
		{
			$errors = 'Comment does not exist.';
		}

		return Redirect::back()->withErrors($errors);
	}
}