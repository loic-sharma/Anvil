<?php

Autoloader::map(array(

	'PageService' => __DIR__.'/services/PageService.php',
));

App::make('view')->addNamespace('pages', __DIR__.'/views');