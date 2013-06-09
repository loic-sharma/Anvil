<?php

class BlogPostVariable extends Variable {

	/**
	 * Get the variable's service.
	 *
	 * @return mixed
	 */
	public function service()
	{
		return new Blog\Post;
	}
}