<?php

use Anvil\Plugins\Plugin;

class PluginStub extends Plugin {

	public function test($foo, $bar = 'default')
	{
		return $foo.' '.$bar;
	}
}