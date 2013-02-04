<?php namespace Cms\Modules;

interface LoaderInterface {

	/**
	 * Get all of the existing modules.
	 *
	 * @return array
	 */
	public function get();
}