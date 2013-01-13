<?php

class UsersAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Users');
	}

	public function getGroups()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Groups');
	}

	public function getPermissions()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Groups', 'admin/users/groups');
		$this->page->addBreadcrumb('Permissions');
	}
}