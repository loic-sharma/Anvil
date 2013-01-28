<?php

class PageAdminController extends Controller {

	/**
	 * View the admin panel home page.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$this->page->addBreadcrumb('Pages');
		$this->page->setContent('page::admin.home');
	}

	/**
	 * Show the form to edit a page.
	 *
	 * @return void
	 */
	public function getEdit($slug)
	{
		$page = Page::where('slug', $slug)->first();

		if(is_null($page))
		{
			return Redirect::to('admin/page');
		}

		else
		{
			$this->page->addBreadcrumb('Pages', 'admin/pages');
			$this->page->addBreadcrumb('Edit Page');
			
			$this->page->setContent('page::admin.edit', compact('page'));
		}
	}

	/**
	 * Edit a page.
	 *
	 * @return Illuminate\Http\RedirectResponse
	 */
	public function postEdit($slug)
	{
		$page = Page::where('slug', $slug)->first();

		if(is_null($page))
		{
			$errors = new MessageBag(array(
				'page' => 'Page does not exist.',
			));
		}

		else
		{
			$page->title = Input::get('title');
			$page->content = Input::get('content');
			$page->comments_enabled = Input::get('comments_enabled', 0);

			if($page->save())
			{
				return Redirect::to('admin/page/'.$slug.'/edit')
						->with('message', 'Successfully edited page.');
			}

			else
			{
				$errors = $page->errors();
			}
		}

		return Redirect::back()
				->withInput()
				->withErrors($errors);
	}
}