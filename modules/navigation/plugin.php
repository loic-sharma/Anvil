<?php

class NavigationPlugin {

	/**
	 * Get all of the navigation groups.
	 *
	 * @return array
	 */
	public function groups()
	{
		return Navigation\Menu::all();
	}

	/**
	 * Fetch the menu to the current section.
	 *
	 * @return  string
	 */
	public function mainMenu()
	{
		if(Cms::isAdmin())
		{
			return $this->menu('admin');
		}

		else
		{
			return $this->menu('header');
		}
	}

	/**
	 * Display a menu.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function menu($name)
	{
		$power = Auth::user()->group->power;

		return $this->get($name, $power)->render();
	}

	/**
	 * Retrieve a menu.
	 *
	 * @param  string  $name
	 * @return Menu\Items\Collection
	 */
	protected function get($name, $power = null)
	{
		$menu = Menu::get($name);
		$me = $this;

		// We first need to get all of the links that the current user
		// has access to on the menu. We'll cache these links too.
		$links = Cache::remember('navigation-links-'.$name.'-'.$power, 60, function() use($me, $name, $power)
		{
			return $me->fetchLinks($name, $power);
		});

		// Now, add the links to the menu.
		return $this->populateMenu($menu, $links);
	}

	/**
	 * Fetch a menu's links.
	 *
	 * @param  string  $name
	 * @param  int     $power
	 * @return array
	 */
	public function fetchLinks($name, $power = null)
	{
		// Filter the links that do not fit the power's requirements if a
		// power is given.
		$links = 'links';

		if( ! is_null($power))
		{
			$links = array('links' => function($query) use($power)
			{
				$query->where(function($query) use ($power)
				{
					$query->whereNull('required_power');
					$query->orWhere('required_power', '<=', $power);
				});

				$query->where(function($query) use($power)
				{
					$query->whereNull('max_power');
					$query->orWhere('max_power', '>=', $power);
				});
			});
		}

		$menu = Navigation\Menu::with($links)
					->where('slug', '=', $name)
					->first();


		if( ! is_null($menu))
		{
			return $menu->links;
		}

		else
		{
			return array();
		}
	}

	/**
	 * Add the menu's links to the menu.
	 *
	 * @param  Menu\Menu  $menu
	 * @param  array      $links
	 * @return Menu\Menu
	 */
	public function populateMenu($menu, $links)
	{
		foreach($links as $link)
		{
			$parent = $this->getParent($menu, $link);

			$parent->add($link->title, function($item) use ($link)
			{
				$item['id']  = $link->id;
				$item['url'] = $link->url;
			});

			// Let's also add a dropdown.
			$parent['li.class'] = 'dropdown';
			$parent['a.role'] = 'button';
			$parent['a.class'] = 'dropdown-toggle';
			$parent['a.data-toggle'] = 'dropdown';
			$parent['ul.class'] = 'dropdown-menu';
			$parent['ul.role'] = 'menu';
		}

		return $menu;
	}

	/**
	 * Get a link's parent menu.
	 *
	 * @param  Menu\Items\Collection
	 * @param  Menu\Items\Item
	 * @return Menu\Items\Item
	 */
	protected function getParent($menu, $link)
	{
		$parent = $menu;

		if( ! is_null($link->parent_id))
		{
			// Fetch the item whose id matches the current item's parent id.
			$parent = $menu->get(function($item) use ($link)
			{
				return ($item['id'] == $link->parent_id);
			});

			// If there are no items that match the current item's parent id,
			// simply add it to the menu.
			if(is_null($parent))
			{
				// To do: throw an exception?
				$parent = $menu;
			}
		}

		return $parent;
	}
}