<?php

use Anvil\Routing\UriInspector;

class UriInspectorTest extends PHPUnit_Framework_TestCase {

	public function testHomePage()
	{
		$inspector = $this->getInspector('/', null);
		$this->assertTrue($inspector->isHome());

		$inspector = $this->getInspector('/', 'FooController');
		$this->assertTrue($inspector->isHome());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('/', $inspector->detectRoute());

		$inspector = $this->getInspector('test', 'FooController');
		$this->assertFalse($inspector->isHome());
		$this->assertEquals('TestController', $inspector->detectController());
		$this->assertEquals('test', $inspector->detectRoute());

		$inspector = $this->getInspector('foo', 'FooController');
		$this->assertTrue($inspector->isHome());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('foo', $inspector->detectRoute());

		$inspector = $this->getInspector('foo', 'BarController');
		$this->assertFalse($inspector->isHome());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('foo', $inspector->detectRoute());
	}

	public function testHomePageFailsWithExtraUriSegments()
	{
		$inspector = $this->getInspector('foo', 'FooController');
		$this->assertTrue($inspector->isHome());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('foo', $inspector->detectRoute());

		$inspector = $this->getInspector('foo/bar', 'FooController');
		$this->assertFalse($inspector->isHome());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('foo', $inspector->detectRoute());
	}

	public function testAdminRoutes()
	{
		$inspector = $this->getInspector('/', 'FooController');
		$this->assertFalse($inspector->isAdmin());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('/', $inspector->detectRoute());

		$inspector = $this->getInspector('foo/bar', null);
		$this->assertFalse($inspector->isAdmin());
		$this->assertEquals('FooController', $inspector->detectController());
		$this->assertEquals('foo', $inspector->detectRoute());

		$inspector = $this->getInspector('admin', null);
		$this->assertTrue($inspector->isAdmin());
		$this->assertEquals(UriInspector::ADMIN_HOME_CONTROLLER, $inspector->detectController());
		$this->assertEquals('admin', $inspector->detectRoute());

		$inspector = $this->getInspector('admin', 'FooController');
		$this->assertTrue($inspector->isAdmin());
		$this->assertEquals(UriInspector::ADMIN_HOME_CONTROLLER, $inspector->detectController());
		$this->assertEquals('admin', $inspector->detectRoute());

		$inspector = $this->getInspector('admin/foo', null);
		$this->assertTrue($inspector->isAdmin());
		$this->assertEquals('FooAdminController', $inspector->detectController());
		$this->assertEquals('admin/foo', $inspector->detectRoute());

		$inspector = $this->getInspector('admin/foo', 'FooController');
		$this->assertTrue($inspector->isAdmin());
		$this->assertEquals('FooAdminController', $inspector->detectController());
		$this->assertEquals('admin/foo', $inspector->detectRoute());

		$inspector = $this->getInspector('admin/foo/bar', 'FooController');
		$this->assertTrue($inspector->isAdmin());
		$this->assertEquals('FooAdminController', $inspector->detectController());
		$this->assertEquals('admin/foo', $inspector->detectRoute());
	}

	public function getInspector($uri, $defaultController)
	{
		return new UriInspector($uri, $defaultController);
	}
}