<?php namespace Cms\Settings;

interface LoaderInterface {

	/**
	 * Retrieve the current settings.
	 *
	 * @return array
	 */
	public function get();

	/**
	 * Save the new settings.
	 *
	 * @param  array  $settings
	 * @return array
	 */
	public function save(array $settings);
}