<?php

return array(

	'fetch' => PDO::FETCH_CLASS,

	'default' => 'website',

	'connections' => array(

		'website' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'cms',
			'username'  => 'root',
			'password'  => 'root',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
	),
);