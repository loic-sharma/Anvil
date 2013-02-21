<?php

Schema::dropIfExists('groups');

Schema::create('groups', function($table)
{
	$table->increments('id');

	$table->string('name')->nullable();
	$table->integer('power')->default(0);
	$table->text('permissions')->nullable();
});