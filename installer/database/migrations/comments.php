<?php

Schema::dropIfExists('comments');

Schema::create('comments', function($table)
{
	$table->increments('id');

	$table->integer('author_id');
	$table->integer('post_id');
	$table->string('area')->nullable();
	$table->text('content')->nullable();

	$table->timestamps();
});
