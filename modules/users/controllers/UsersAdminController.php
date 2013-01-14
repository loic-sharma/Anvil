<?php

class UsersAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Users');

		$this->page->setContent('users::admin.home');
	}

	public function getGroups()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Groups');

		$this->page->setContent('users::admin.groups');
	}

	public function getPermissions()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Groups', 'admin/users/groups');
		$this->page->addBreadcrumb('Permissions');
	}
}