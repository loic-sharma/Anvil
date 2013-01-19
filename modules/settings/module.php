<?php

class SettingsModule {

	/**
	 * The module's full name.
	 *
	 * @var string
	 */
	public $name = 'Settings Module';

	/**
	 * The module's description.
	 *
	 * @var string
	 */
	public $description = 'Manage your site\'s settings.';

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
	public $slug = 'settings';

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