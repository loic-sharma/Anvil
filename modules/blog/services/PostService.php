<?php

namespace Blog;

class PostService {

	public function getPosts($offset = 0, $limit = 10)
	{
		return Post::with('author')
					->orderBy('created_at', 'ASC')
					->skip($offset)
					->take($limit)
					->get();
	}

	public function getPostById($id)
	{
		return Post::with(array('author', 'comments', 'comments.author'))
					->where('id', '=', $id)
					->first();
	}
}