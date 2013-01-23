<?php

Autoloader::map(array(
	'BlogController' => __DIR__.'/controllers/BlogController.php',

	'Blog\Post'        => __DIR__.'/models/Post.php',
));