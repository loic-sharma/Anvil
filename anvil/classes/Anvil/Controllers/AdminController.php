<?php namespace Anvil\Controllers;

use Anvil\Routing\Controllers\Controller;

class AdminController extends Controller {

	/**
	 * Display the admin home page.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$this->page->addBreadcrumb('Home');

		$this->page->setContent('admin::home');
	}
}