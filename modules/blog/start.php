<?php

Autoloader::map(array(
	'BlogController' => __DIR__.'/controllers/BlogController.php',

	'Blog\Post'        => __DIR__.'/models/Post.php',
	'Blog\Comment'     => __DIR__.'/models/Comment.php',
	'Blog\PostService' => __DIR__.'/services/PostService.php',
));