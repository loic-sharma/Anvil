<?php

class NavigationAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Navigation');
	}
}