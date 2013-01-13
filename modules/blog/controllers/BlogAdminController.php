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
}