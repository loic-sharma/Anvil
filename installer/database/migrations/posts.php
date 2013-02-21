<?php

Schema::dropIfExists('posts');

Schema::create('posts', function($table)
{
	$table->increments('id');

	$table->integer('author_id');
	$table->string('title');
	$table->text('content');
	$table->integer('comments_enabled');

	$table->timestamps();
});