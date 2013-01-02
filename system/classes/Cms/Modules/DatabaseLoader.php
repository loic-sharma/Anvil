<?php

namespace Cms\Modules;

use Illuminate\Database\DatabaseManager;

class DatabaseLoader implements LoaderInterface {

	/**
	 * The database instance.
	 *
	 * @var DatabaseManager
	 */
	protected $database;

	/**
	 * All of the registered modules.
	 *
	 * @var array
	 */
	protected $modules = array();

	/**
	 * Save the Database Manager instance.
	 *
	 * @return void
	 */
	public function __construct(DatabaseManager $database)
	{
		$this->database = $database;
	}

	/**
	 * Get all of the existing modules.
	 *
	 * @return array
	 */
	public function get()
	{
		if(empty($this->modules))
		{
			$modules = $this->database->table('modules')->get();

			foreach($modules as $module)
			{
				$this->modules[$module->slug] = $module;
			}
		}

		return $this->modules;
	}
}