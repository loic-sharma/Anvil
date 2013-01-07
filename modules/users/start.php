<?php

Autoloader::map(array(
	'UserController' => __DIR__.'/controllers/UserController.php',

	'User' => __DIR__.'/models/User.php',

	'UsersPlugin' => __DIR__.'/plugins/Users.php',
	'UserPlugin'  => __DIR__.'/plugins/User.php',
));

Plugins::register('users', new UsersPlugin);
Plugins::register('user', new UserPlugin);