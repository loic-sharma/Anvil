<?php namespace Anvil\Modules;

use Illuminate\Database\DatabaseManager;

class DatabaseLoader implements LoaderInterface {

	/**
	 * The database instance.
	 *
	 * @var Illuminate\Database\DatabaseManager
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
	 * @param  Illuminate\Database\DatabaseManager $database
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
			// Let's fetch the modules from the database. Note that we
			// order the modules by 'is_core' in descending order to
			// ensure that the core modules will be fetched first.
			$modules = $this->database->table('modules')
						->orderBy('is_core', 'desc')
						->get();

			// Organize the modules by their slugs. 
			foreach($modules as $module)
			{
				$this->modules[$module->slug] = new Module($module);
			}
		}

		return $this->modules;
	}
}