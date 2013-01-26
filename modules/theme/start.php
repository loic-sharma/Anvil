<?php

Autoloader::map(array(
	'ThemePlugin'  => __DIR__.'/plugins/Theme.php',
	'ThemesPlugin' => __DIR__.'/plugins/Themes.php',
));

Plugins::register('theme', new ThemePlugin);
Plugins::register('themes', new ThemesPlugin);