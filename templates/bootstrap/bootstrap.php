<?php

$navigation = App::make('plugins')->navigation;

$navigation->factory->filter(function($item)
{
	if($item['a.href'] == Url::current())
	{
		$item['li.class'] = 'active';
	}
});