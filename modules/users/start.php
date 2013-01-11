<?php

Autoloader::map(array(
	'UsersController' => __DIR__.'/controllers/UsersController.php',

//	'User' => __DIR__.'/models/User.php',

	'UsersPlugin' => __DIR__.'/plugins/Users.php',
	'UserPlugin'  => __DIR__.'/plugins/User.php',
));

Plugins::register('users', new UsersPlugin);
Plugins::register('user', new UserPlugin);