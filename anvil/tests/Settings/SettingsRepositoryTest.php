<?php

class SettingsRepositoryTest extends PHPUnit_Framework_TestCase {

	public function testFetchSettings()
	{
		$expected = array('foo' => 'bar', 'fooz' => 'baz');

		$loader = $this->getMock('Anvil\Settings\LoaderInterface');
		$loader->expects($this->once())
			->method('get')
			->will($this->returnValue($expected));

		$repository = new Anvil\Settings\Repository($loader);

		$this->assertEquals($expected, $repository->fetch());
	}

	public function testGetSetting()
	{
		$settings = array('foo' => 'bar', 'fooz' => 'baz');

		$loader = $this->getMock('Anvil\Settings\LoaderInterface');
		$loader->expects($this->once())
			->method('get')
			->will($this->returnValue($settings));

		$repository = new Anvil\Settings\Repository($loader);

		$this->assertEquals($settings['foo'], $repository->get('foo'));
		$this->assertEquals('default', $repository->get('fake', 'default'));
	}

	public function testSetSetting()
	{
		$expected = 'foobar';

		$loader = $this->getMock('Anvil\Settings\LoaderInterface');
		$repository = new Anvil\Settings\Repository($loader);

		$this->assertEquals('default', $repository->get('fake', 'default'));

		$repository->set('fake', $expected);

		$this->assertEquals($expected, $repository->get('fake', 'default'));
	}

	public function testSaveOnUnset()
	{
		$expected = array('foo' => 'bar', 'fooz' => 'baz');

		$loader = $this->getMock('Anvil\Settings\LoaderInterface');
		$loader->expects($this->once())
			->method('save')
			->with($expected);

		$repository = new Anvil\Settings\Repository($loader);

		$repository->set('foo', 'bar');
		$repository->set('fooz', 'baz');

		unset($repository);
	}
}