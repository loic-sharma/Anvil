<?php

Autoloader::map(array(

	'Comment' => __DIR__.'/models/Comment.php',
));

View::composer('comments::comments', function($event)
{
	$data = $event->view->getData();

	if(isset($data['area']))
	{
		if( ! isset($data['comments']))
		{
			$event->view->with('comments', Comment::with('author')
				->where('area', $data['area'])
				->orderBy('id', 'DESC')
				->get());
		}
	}
});