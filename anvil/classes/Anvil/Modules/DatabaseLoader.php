<?php namespace Anvil\Modules;

use Illuminate\Database\DatabaseManager;

class DatabaseLoader extends AbstractLoader {

	/**
	 * The database instance.
	 *
	 * @var Illuminate\Database\DatabaseManager
	 */
	protected $database;

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
	 * Fetch the installed modules from the database.
	 *
	 * @return array
	 */
	public function fetch()
	{
		// We order the modules by 'is_core' in descending order
		// to ensure that the core modules will be fetched first.
		return $this->database->table('modules')
					->orderBy('is_core', 'desc')
					->get();
	}
}