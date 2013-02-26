<?php

class PluginPluginTest extends PHPUnit_Framework_TestCase {

	public function testAttributes()
	{
		$attributes = array('foo' => 'bar');

		$plugin = $this->getMockForAbstractClass('Anvil\Plugins\Plugin');
		$plugin->setAttributes($attributes);

		$this->assertEquals($attributes['foo'], $plugin->attribute('foo'));
	}

	public function testResetAttributes()
	{
		$attributes = array('foo' => 'bar');
		$expected = 'Expected';

		$plugin = $this->getMockForAbstractClass('Anvil\Plugins\Plugin');
		$plugin->setAttributes($attributes);
		$plugin->resetAttributes();

		$this->assertEquals($expected, $plugin->attribute('foo', $expected));
	}

	public function testNonEloquentModelCalls()
	{
		$expected = 'Expected';

		$model = $this->getMock('Model', array('test'));
		$model->expects($this->once())
			->method('test')
			->will($this->returnValue($expected));

		$plugin = $this->getMockForAbstractClass('Anvil\Plugins\Plugin');
		$plugin->model = $model;

		$this->assertEquals($expected, $plugin->test());
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