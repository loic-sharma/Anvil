<?php

use Anvil\Plugins\Plugin;
use Illuminate\Database\Eloquent\Model;

class PluginPluginTest extends PHPUnit_Framework_TestCase {

	public function testAttributes()
	{
		$attributes = array('foo' => 'bar');

		$plugin = new PluginStub;
		$plugin->setAttributes($attributes);

		$this->assertEquals($attributes['foo'], $plugin->attribute('foo'));
	}

	public function testResetAttributes()
	{
		$attributes = array('foo' => 'bar');
		$expected = 'Expected';

		$plugin = new PluginStub;
		$plugin->setAttributes($attributes);
		$plugin->resetAttributes();

		$this->assertEquals($expected, $plugin->attribute('foo', $expected));
	}

	public function testNonEloquentModelCalls()
	{
		$expected = 'Expected';

		$model = $this->getMock('Model', array('foo'));
		$model->expects($this->once())
			->method('foo')
			->will($this->returnValue($expected));

		$plugin = new PluginStub;
		$plugin->model = $model;

		$this->assertEquals($expected, $plugin->foo());
	}

	public function testEloquentModelCalls()
	{
		$expected = 'Expected';

		$query = $this->getMock('Model', array('test'));
		$query->expects($this->once())
			->method('test')
			->will($this->returnValue($expected));

		$model = $this->getMock('Illuminate\Database\Eloquent\Model');
		$model->expects($this->once())
			->method('newQuery')
			->will($this->returnValue($query));

		$plugin = $this->getMockForAbstractClass('Anvil\Plugins\Plugin');
		$plugin->model = $model;

		$this->assertEquals($expected, $plugin->test());
	}
}

class PluginStub extends Plugin {}