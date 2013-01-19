<?php

class LangModule {

	/**
	 * The module's full name.
	 *
	 * @var string
	 */
	public $name = 'Language Module';

	/**
	 * The module's description.
	 *
	 * @var string
	 */
	public $description = 'Modify the language.';

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
	public $slug = 'lang';

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