<?php

Autoloader::map(array(
	'TemplatePlugin'  => __DIR__.'/plugins/Template.php',
	'TemplatesPlugin' => __DIR__.'/plugins/Templates.php',
));

Plugins::register('template', new TemplatePlugin);
Plugins::register('templates', new TemplatesPlugin);