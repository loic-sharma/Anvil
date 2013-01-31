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

	public function getCreate()
	{
		$editing = false;
		$page = new Page;

		$this->page->addBreadcrumb('Pages', 'admin/page');
		$this->page->addBreadcrumb('Add Page');

		$this->page->setContent('page::admin.page', compact('editing', 'page'));
	}

	public function postCreate()
	{
		$page = new Page;

		$page->title = Input::get('title');
		$page->slug = strtolower(str_replace(' ', '-', $page->title));
		$page->content = Input::get('content');
		$page->comments_enabled = Input::get('comments_enabled', 0);

		if($page->save())
		{
			return Redirect::to('admin/page/'.$page->slug.'/edit');
		}

		else
		{
			return Redirect::to('admin/page/create')
					->withInput()
					->withErrors($page->errors());
		}
	}

	/**
	 * Show the form to edit a page.
	 *
	 * @return void
	 */
	public function getEdit($slug)
	{
		$editing = true;
		$page = Page::where('slug', $slug)->first();

		if(is_null($page))
		{
			return Redirect::to('admin/page');
		}

		else
		{
			$this->page->addBreadcrumb('Pages', 'admin/page');
			$this->page->addBreadcrumb('Edit Page');
			
			$this->page->setContent('page::admin.page', compact('editing', 'page'));
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