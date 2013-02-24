<?php

Schema::dropIfExists('settings');

Schema::create('settings', function($table)
{
	$table->increments('id');

	$table->string('key')->unique();
	$table->text('value')->nullable();
});
