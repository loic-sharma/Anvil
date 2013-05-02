<?php

use Anvil\Modules\Module;
use Anvil\Modules\Repository;


class ModuleTest extends PHPUnit_Framework_TestCase {

	public function testBooting()
	{
		$filesystem = $this->getFilesystemMock();
		$filesystem->expects($this->once())
			->method('isDirectory')
			->will($this->returnValue(true));
		$filesystem->expects($this->once())
			->method('files')
			->will($this->returnValue(array()));

		$autoloader = $this->getMock('Composer\Autoload\ClassLoader');

		$repository = $this->getMockRepository();
		$repository->expects($this->once())
			->method('getFiles')
			->will($this->returnValue($filesystem));

		$repository->expects($this->once())
			->method('getAutoloader')
			->will($this->returnValue($autoloader));


		$module = new Module($repository, new ModuleStub);

		$module->boot();
	}

	public function getFilesystemMock()
	{
		return $this->getMock('Illuminate\Filesystem\Filesystem');
	}

	public function getMockRepository()
	{
		return $this->getMock('RepositoryStub');
	}
}

class ModuleStub {

	public $slug = 'foo';
}

class RepositoryStub extends Repository {

	public function __construct() {}

	public function getFiles()
	{
		return new Illuminate\Filesystem\Filesystem;
	}
}