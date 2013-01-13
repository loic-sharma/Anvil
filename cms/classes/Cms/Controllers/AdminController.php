<?php

namespace Cms\Controllers;

use Cms\Routing\Controllers\Controller;

class AdminController extends Controller {

	/**
	 * Display the admin home page.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		$this->page->addBreadcrumb('Home');
	}
}