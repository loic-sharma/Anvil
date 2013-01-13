<?php

namespace Cms\Controllers;

use Cms\Routing\Controllers\Controller;

class AdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Home');
	}
}