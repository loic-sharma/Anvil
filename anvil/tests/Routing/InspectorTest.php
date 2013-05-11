<?php

use Illuminate\Http\Request;
use Anvil\Routing\Inspector\AdminInspector;
use Anvil\Routing\Inspector\DefaultInspector;
use Anvil\Routing\Inspector\Route;

class InspectorTest extends PHPUnit_Framework_TestCase {

	public function testAdminInspector()
	{
		$inspector = new AdminInspector;

		$route = new Route(Request::create('/'));
		$this->assertEquals(null, $inspector->inspect($route));

		$route = new Route(Request::create('foo'));
		$this->assertEquals(null, $inspector->inspect($route));

		$route = new Route(Request::create('admin'));
		$route = $inspector->inspect($route);
		$this->assertEquals(true, $route->isAdmin);
		$this->assertEquals('admin', $route->route);
		$this->assertEquals('Anvil\Controllers\AdminController', $route->controller);

		$route = new Route(Request::create('admin/foo'));
		$route = $inspector->inspect($route);
		$this->assertEquals(true, $route->isAdmin);
		$this->assertEquals('admin/foo', $route->route);
		$this->assertEquals('FooAdminController', $route->controller);

		$route = new Route(Request::create('admin/foo/bar'));
		$route = $inspector->inspect($route);
		$this->assertEquals(true, $route->isAdmin);
		$this->assertEquals('admin/foo', $route->route);
		$this->assertEquals('FooAdminController', $route->controller);
	}

	public function testDefaultInspector()
	{

	}
}