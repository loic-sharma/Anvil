<?php

Plugins::get('theme')->addAsset('css', 'css/bootstrap.css');

if(Auth::user()->can('access_admin_panel'))
{
	Plugins::get('theme')->addAsset('js', 'js/ckeditor/ckeditor.js');
	Plugins::get('theme')->addAsset('js', 'js/edit.js');
}

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