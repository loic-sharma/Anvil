<?php

return array(
	array(
		'name'        => 'guest',
		'power'       => 0,
		'permissions' => NULL,
	),
	array(
		'name'        => 'user',
		'power'       => 1,
		'permissions' => NULL,
	),
	array(
		'name'        => 'moderator',
		'power'       => 50,
		'permissions' => NULL,
	),
	array(
		'name'        => 'admin',
		'power'       => 100,
		'permissions' => serialize(array('access_admin_panel' => true)),
	),
);