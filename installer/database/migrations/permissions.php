<?php

Schema::dropIfExists('permissions');

Schema::create('permissions', function($table)
{
	$table->increments('id');

	$table->string('slug')->unique();
	$table->string('name')->nullable();
	$table->integer('required_power')->nullable();
	$table->integer('max_power')->nullabe();
});
