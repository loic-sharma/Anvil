<?php

class ModulesAdminController extends Controller {

	/**
	 * Display the admin home page.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$this->page->addBreadcrumb('Module');
		$this->page->setContent('modules::admin.home');
	}
}