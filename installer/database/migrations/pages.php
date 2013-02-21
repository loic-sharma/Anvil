<?php

Schema::dropIfExists('pages');

Schema::create('pages', function($table)
{
	$table->increments('id');

	$table->string('slug')->unique();
	$table->string('title')->nullable();
	$table->string('layout')->nullable();
	$table->text('content')->nullable();
	$table->integer('comments_enabled')->default(1);

	$table->timestamps();
});