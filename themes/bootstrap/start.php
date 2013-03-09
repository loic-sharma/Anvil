<?php

Plugins::get('theme')->addAsset('css', 'css/bootstrap.css');

if(Auth::user()->can('access_admin_panel'))
{
	Plugins::get('theme')->addAsset('js', 'js/ckeditor/ckeditor.js');
	Plugins::get('theme')->addAsset('js', 'js/edit.js');
}

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