<?php

Autoloader::map(array(
	'PageController' => __DIR__.'/controllers/PageController.php',

	'PagesPlugin' => __DIR__.'/plugins/Pages.php',

	'Page\Breadcrumb' => __DIR__.'/classes/Breadcrumb.php',
));

Plugins::register('pages', new PagesPlugin);