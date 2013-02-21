<?php

return array(
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
);