<?php

Menu::filter(function($item)
{
	if($item['a.href'] == Url::current())
	{
		$item['li.class'] = 'active';
	}

	else
	{
		if($item['a.href'] == Url::base())
		{
			if(app()->isHome() == true)
			{
				$item['li.class'] = 'active';
			}
		}
	}
});