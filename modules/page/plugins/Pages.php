<?php

class PagesPlugin {

	/**
	 * Retrieve pages.
	 *
	 * @return array
	 */
	public function get()
	{
		return Page::all();
	}
}