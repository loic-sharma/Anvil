<?php

Schema::dropIfExists('users');

Schema::create('users', function($table)
{
	$table->increments('id');

	$table->integer('group_id')->nullable();
	$table->string('email');
	$table->string('password');
	$table->text('permissions')->nullable();
	$table->string('first_name')->nullable();
	$table->string('last_name')->nullable();

	$table->timestamps();
});