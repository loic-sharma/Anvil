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
}