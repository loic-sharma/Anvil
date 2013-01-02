<?php


use Menu\Factory as MenuFactory;
use Menu\FilterRepository as MenuFilter;
use Menu\Renderer as MenuRenderer;

class NavigationPlugin extends Plugin {

	public $factory;
	public $renderer;
	public $menus = array();

	public function __construct()
	{
		// todo, service providers...
		$this->factory  = new MenuFactory(new MenuFilter, new MenuRenderer);
	}

	public function links($group)
	{
		return $this->getMenu($group)->render();
	}

	protected function getMenu($group)
	{
		$menu = $this->factory->get($group);

		if( ! in_array($group, $this->menus))
		{
			$this->menus[] = $group;

			$group = Navigation\Group::with('links')
						->where('slug', '=', $group)
						->first();

			if( ! is_null($group))
			{
				foreach($group->links as $link)
				{
					$parentItem = $menu;

					if( ! is_null($link->parent_id))
					{
						// Fetch the item whose id matches the current item's parent id.
						$parentItem = $menu->get(function($item) use ($link)
						{
							return ($item['id'] == $link->parent_id);
						});

						// If there are no items that match the current item's parent id,
						// simply add it to the menu.
						if(is_null($parentItem))
						{
							// @todo: throw exception?
							$parentItem = $menu;
						}
					}

					$parentItem->add($link->title, function($item) use ($link)
					{
						$item['id']  = $link->id;
						$item['url'] = $link->url;
 					});
				}
			}
		}

		return $menu;
	}
}