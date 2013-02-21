<?php

Schema::dropIfExists('modules');

Schema::create('modules', function($table)
{
	$table->increments('id');

	$table->string('slug')->unique();
	$table->integer('enabled')->default(0);
	$table->integer('installed')->default(0);
	$table->integer('is_core')->default(0);
});