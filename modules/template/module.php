<?php

class TemplateModule {

	/**
	 * The module's full name.
	 *
	 * @var string
	 */
	public $name = 'Template Module';

	/**
	 * The module's description.
	 *
	 * @var string
	 */
	public $description = 'Manage your templates.';

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
	public $slug = 'template';

	/**
	 * Wether the module has an admin panel.
	 *
	 * @var bool
	 */ 
	public $hasAdminPanel = false;

	/**
	 * Wether the module is a core module. 
	 *
	 * @var bool
	 */
	public $isCore = true;
}