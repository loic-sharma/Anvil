<?php

return array(

	// Main Menu Links
	array(
		'menu_id'   => 1,
		'parent_id' => NULL,
		'title'     => 'Home',
		'url'       => '{url}/',
		'max_power' => NULL,
		'required_power' => NULL,
	),
	array(
		'menu_id'   => 1,
		'parent_id' => NULL,
		'title'     => 'Contact',
		'url'       => '{url}/page/contact',
		'max_power' => NULL,
		'required_power' => NULL,
	),

	// Sidebar links
	array(
		'menu_id'   => 2,
		'parent_id' => NULL,
		'title'     => 'User Control Panel',
		'url'       => '{url}/profile',
		'max_power' => NULL,
		'required_power' => 1,
	),
	array(
		'menu_id'   => 2,
		'parent_id' => NULL,
		'title'     => 'Admin Control Panel',
		'url'       => '{adminUrl}/',
		'max_power' => NULL,
		'required_power' => 100,
	),
	array(
		'menu_id'   => 2,
		'parent_id' => NULL,
		'title'     => 'Logout',
		'url'       => '{url}/logout',
		'max_power' => NULL,
		'required_power' => 1,
	),
	array(
		'menu_id'   => 2,
		'parent_id' => NULL,
		'title'     => 'Login',
		'url'       => '{url}/login',
		'max_power' => 0,
		'required_power' => NULL,
	),

	// Admin Menu Links
	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Blog',
		'url'       => '{adminUrl}/blog',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Comments',
		'url'       => '{adminUrl}/comments',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Modules',
		'url'       => '{adminUrl}/modules',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Navigation',
		'url'       => '{adminUrl}/navigation',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Blog',
		'url'       => '{adminUrl}/blog',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Page',
		'url'       => '{adminUrl}/page',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Settings',
		'url'       => '{adminUrl}/settings',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Theme',
		'url'       => '{adminUrl}/theme',
		'max_power' => NULL,
		'required_power' => 100,
	),

	array(
		'menu_id'   => 3,
		'parent_id' => NULL,
		'title'     => 'Users',
		'url'       => '{adminUrl}/users',
		'max_power' => NULL,
		'required_power' => 100,
	),
);