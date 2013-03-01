<?php

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder as Query;

class DatabaseLoaderTest extends PHPUnit_Framework_TestCase {

	public function testGetSettings()
	{
		$settings = $this->getSettings();
		$expected = array('foo' => 'bar', 'fooz' => 'baz');

		$query = $this->getMock('DatabaseLoaderQueryStub');
		$query->expects($this->once())
			->method('get')
			->will($this->returnValue($settings));

		$database = $this->getMock('DatabaseLoaderDatabaseManagerStub', array('table'));
		$database->expects($this->once())
			->method('table')
			->with('settings')
			->will($this->returnValue($query));

		$loader = new Anvil\Settings\DatabaseLoader($database);

		$this->assertEquals($expected, $loader->get());
	}

	public function testInsertSettings()
	{
		$query = $this->getMock('DatabaseLoaderQueryStub', array('insert'));
		$query->expects($this->exactly(2))
			->method('insert');

		$database = $this->getMock('DatabaseLoaderDatabaseManagerStub', array('table'));
		$database->expects($this->exactly(2))
			->method('table')
			->with('settings')
			->will($this->returnValue($query));

		$loader = new Anvil\Settings\DatabaseLoader($database);

		$loader->save(array('foo' => 'bar', 'fooz' => 'baz'));
	}

	public function testUpdateSettings()
	{
		$settings = $this->getSettings();

		$query = $this->getMock('DatabaseLoaderQueryStub', array('get', 'update'));
		$query->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue($settings));
		$query->expects($this->exactly(2))
			->method('update');

		$database = $this->getMock('DatabaseLoaderDatabaseManagerStub', array('table'));
		$database->expects($this->exactly(3))
			->method('table')
			->with('settings')
			->will($this->returnValue($query));

		$loader = new Anvil\Settings\DatabaseLoader($database);

		$loader->get();
		$loader->save(array('foo' => 'new', 'fooz' => 'value'));
	}

	public function testInsertAndUpdateSettings()
	{
		$settings = $this->getSettings();

		$query = $this->getMock('DatabaseLoaderQueryStub', array('get', 'update', 'insert'));
		$query->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue($settings));
		$query->expects($this->exactly(2))
			->method('update');
		$query->expects($this->exactly(1))
			->method('insert');

		$database = $this->getMock('DatabaseLoaderDatabaseManagerStub', array('table'));
		$database->expects($this->exactly(4))
			->method('table')
			->with('settings')
			->will($this->returnValue($query));

		$loader = new Anvil\Settings\DatabaseLoader($database);

		$loader->get();
		$loader->save(array('foo' => 'new', 'fooz' => 'value', 'insert' => 'this'));
	}

	protected function getSettings()
	{
		return array(
			(object) array(
				'key' => 'foo',
				'value' => serialize('bar'),
			),
			(object) array(
				'key' => 'fooz',
				'value' => serialize('baz'),
			),
		);

	}
}

class DatabaseLoaderDatabaseManagerStub extends DatabaseManager {

	public function __construct() {}
}

class DatabaseLoaderQueryStub extends Query {

	public function __construct() {}
}