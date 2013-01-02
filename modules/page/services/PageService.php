<?php

class PageService {

	public function getPageById($id)
	{
		return Page::where('id', '=', $id)->first();
	}

	public function getPageBySlug($slug)
	{
		return Page::where('slug', '=', $slug)->first();
	}
}