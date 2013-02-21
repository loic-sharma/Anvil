<?php

Schema::dropIfExists('navigation_links');

Schema::create('navigation_links', function($table)
{
	$table->increments('id');

	$table->integer('menu_id');
	$table->integer('parent_id')->nullable();
	$table->string('title')->nullable();
	$table->string('url')->nullable();
	$table->integer('required_power')->nullable();
	$table->integer('max_power')->nullable();
});