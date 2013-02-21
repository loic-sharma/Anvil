<?php

Schema::dropIfExists('navigation_menus');

Schema::create('navigation_menus', function($table)
{
	$table->increments('id');

	$table->string('slug')->unique();
	$table->string('title')->nullable();
});
