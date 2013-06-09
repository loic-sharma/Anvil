<?php namespace Anvil\Modules;

abstract class Variable {

	/**
	 * Get the variable's service.
	 *
	 * @return mixed
	 */
	abstract public function service();

	/**
	 * Call a method on the service class.
	 *
	 * @param  string  $method
	 * @param  array  $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		$service = $this->service();

		return call_user_func_array(array($service, $method), $parameters);	
	}
}