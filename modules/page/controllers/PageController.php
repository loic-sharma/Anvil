<?php

class PageController extends Controller {

	public $layout = 'layouts.default';

	protected $pageService;

	public function __construct(PageService $pageService)
	{
		$this->pageService = $pageService;
	}

	public function page($page)
	{
		if(is_null($page = $this->pageService->getPageBySlug($page)))
		{
			throw new HttpNotFoundException;
		}

		$this->page->addBreadcrumb($page->title);

		$this->page->content = $page->content;
	}
}