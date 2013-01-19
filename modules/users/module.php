<?php

class UsersModule {

	/**
	 * The module's full name.
	 *
	 * @var string
	 */
	public $name = 'Users Module';

	/**
	 * The module's description.
	 *
	 * @var string
	 */
	public $description = 'Manage your users.';

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
	public $slug = 'users';

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