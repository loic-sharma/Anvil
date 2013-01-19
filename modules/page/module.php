<?php

class PageModule {

	/**
	 * The module's full name.
	 *
	 * @var string
	 */
	public $name = 'Page Module';

	/**
	 * The module's description.
	 *
	 * @var string
	 */
	public $description = 'Manage your pages.';

	/**
	 * The module's version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The module's slug.
	 *
	 * @var string
	 */
	public $slug = 'page';

	/**
	 * Wether the module has an admin panel.
	 *
	 * @var bool
	 */ 
	public $hasAdminPanel = true;

	/**
	 * Wether the module is a core module. 
	 *
	 * @var bool
	 */
	public $isCore = true;
}