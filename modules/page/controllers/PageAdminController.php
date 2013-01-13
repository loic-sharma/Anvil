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
}