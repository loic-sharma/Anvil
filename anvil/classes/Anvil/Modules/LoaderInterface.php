<?php namespace Anvil\Modules;

interface LoaderInterface {

	/**
	 * Get all of the existing modules.
	 *
	 * @return array
	 */
	public function get();
}