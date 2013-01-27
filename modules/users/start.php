<?php

Autoloader::map(array(
	'GroupsAdminController' => __DIR__.'/controllers/GroupsAdminController.php',
	'PermissionAdminController' => __DIR__.'/controllers/PermissionAdminController.php',
	'UsersAdminController' => __DIR__.'/controllers/UsersAdminController.php',
	'UsersController' => __DIR__.'/controllers/UsersController.php',
	

	'PermissionsPlugin' => __DIR__.'/plugins/Permissions.php',
	'GroupsPlugin'      => __DIR__.'/plugins/Groups.php',
	'UsersPlugin'       => __DIR__.'/plugins/Users.php',
	'UserPlugin'        => __DIR__.'/plugins/User.php',
));