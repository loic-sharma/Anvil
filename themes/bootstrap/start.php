<?php

Theme::addStyle('css/bootstrap.css');

Menu::filter(function($item)
{
	if($item->url == Url::current())
	{
		$item->attribute('li.class', 'active');
	}

	else
	{
		if($item->url == Url::base())
		{
			if(Anvil::isHome() == true)
			{
				$item->attribute('li.class', 'active');
			}
		}
	}
});