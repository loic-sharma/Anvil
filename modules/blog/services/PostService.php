<?php

namespace Blog;

class PostService {

	public function getPosts($offset = 0, $limit = 10, $orderBy = 'created_at', $orderDir = 'ASC')
	{
		return Post::with('author')
					->orderBy($orderBy, $orderDir)
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