<?php

class CommentsPlugin extends Plugin {

	/**
	 * Get the comments for a certain area.
	 *
	 * @param  string  $area
	 * @return array
	 */
	public function get($area = null, $order = 'DESC')
	{
		$comments = Comment::with('author');

		if( ! is_null($area))
		{
			$comments->where('area', $area);
		}

		return $comments->orderBy('id', $order)->get();
	}

	/**
	 * A quick helper to show a comment area.
	 *
	 * @param  string  $area
	 * @return string
	 */
	public function show($area, $order = 'DESC')
	{
		$comments = $this->get($area, $order);

		return View::make('comments::comments', compact('area', 'comments'))->render();
	}

	/**
	 * Redirect method calls to the comment model.
	 *
	 * @param  string  $method
	 * @param  string  $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		switch (count($args))
		{
			case 0:
				return Comment::$method();

			case 1:
				return Comment::$method($args[0]);

			case 2:
				return Comment::$method($args[0], $args[1]);

			case 3:
				return Comment::$method($args[0], $args[1], $args[2]);

			case 4:
				return Comment::$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array('Comment', $method), $args);
		}
	}
}