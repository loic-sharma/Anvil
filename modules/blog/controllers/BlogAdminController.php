<?php

class BlogAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Blog');
		$this->page->setContent('blog::admin.home');
	}
}