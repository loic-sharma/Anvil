<?php namespace Anvil\Modules;

abstract class AbstractLoader implements LoaderInterface {

	/**
	 * The module repository.
	 *
	 * @var Anvil\Modules\Repository
	 */
	protected $repository;

	/**
	 * All of the registered modules.
	 *
	 * @var array
	 */
	protected $modules = array();

	/**
	 * Get the modules.
	 *
	 * @return array
	 */
	public function get()
	{
		// Let's not the load the modules more than once.
		if(empty($this->modules))
		{
			// Store the modules by their slug.
			foreach($this->fetch() as $module)
			{
				$this->modules[$module->slug] = new Module($this->repository, $module); 
			}
		}

		return $this->modules;
	}

	/**
	 * Set the module repository.
	 *
	 * @param  Anvil\Modules\Repository
	 * @return void
	 */
	public function setRepository(Repository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Fetch the modules.
	 *
	 * @return array
	 */
	abstract public function fetch();
}