<?php

$app = app();

$navigation = $app->plugins->navigation;

$navigation->factory->filter(function($item) use ($app)
{
	if($item['a.href'] == Url::current())
	{
		$item['li.class'] = 'active';
	}

	else
	{
		if($item['a.href'] == Url::base())
		{
			if($app->isHome() == true)
			{
				$item['li.class'] = 'active';
			}
		}
	}
});