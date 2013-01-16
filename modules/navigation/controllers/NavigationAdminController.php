<?php

class NavigationAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Navigation');

		$this->page->setContent('navigation::admin.home');
	}

	public function getGroup($menu)
	{
		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Group');

		$this->page->setContent('navigation::admin.group', compact('menu'));
	}
}