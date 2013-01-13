<?php

Autoloader::map(array(
	'PageController' => __DIR__.'/controllers/PageController.php',

	'PagesPlugin' => __DIR__.'/plugins/Pages.php',
));

Plugins::register('pages', new PagesPlugin);