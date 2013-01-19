<?php

class NavigationModule {

	/**
	 * The module's full name.
	 *
	 * @var string
	 */
	public $name = 'Navigation Module';

	/**
	 * The module's description.
	 *
	 * @var string
	 */
	public $description = 'Manage your navigation menus.';

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
	public $slug = 'navigation';

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