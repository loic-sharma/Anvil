<?php

Autoloader::map(array(

	'Comment' => __DIR__.'/models/Comment.php',
));

View::composer('comments::comments', function($event)
{
	$data = $event->view->getData();

	// If the view has an area but no comments, we need to
	// load the area's comments.
	if(isset($data['area']) and ! isset($data['comments']))
	{
		$event->view->with('comments', Comment::with('author')
			->where('area', $data['area'])
			->orderBy('id', 'DESC')
			->get());
	}
});