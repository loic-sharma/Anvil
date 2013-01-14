<?php

Autoloader::map(array(
	'UsersController' => __DIR__.'/controllers/UsersController.php',

	'PermissionsPlugin' => __DIR__.'/plugins/Permissions.php',
	'GroupsPlugin'      => __DIR__.'/plugins/Groups.php',
	'UsersPlugin'       => __DIR__.'/plugins/Users.php',
	'UserPlugin'        => __DIR__.'/plugins/User.php',
));

Plugins::register('permissions', new PermissionsPlugin);
Plugins::register('groups', new GroupsPlugin);
Plugins::register('users', new UsersPlugin);

Plugins::register('user', new UserPlugin);