<?php

use Navigation\Group;
use Navigation\Link;

class NavigationPlugin {

	/**
	 * All of the previously retrieve menus.
	 *
	 * @var array
	 */
	public $menus = array();

	/**
	 * Get all of the navigation groups.
	 *
	 * @return array
	 */
	public function groups()
	{
		return Group::all();
	}

	/**
	 * Display a menu.
	 *
	 * @param  string  $group
	 * @return string
	 */
	public function links($group)
	{
		return $this->getMenuLink($group)->render();
	}

	/**
	 * Retrieve a menu.
	 *
	 * @param  string  $group
	 * @return Menu\Items\Collection
	 */
	protected function getMenuLink($group)
	{
		$menu = Menu::get($group);

		if( ! in_array($group, $this->menus))
		{
			$this->menus[] = $group;

			$group = Navigation\Group::with(array('links' => function($query)
			{
				// Take all links that have no required power.
				$query->whereNull('required_power');

				// If the user is logged in, take all links whose required power
				// is less than the user's power.
				if(Auth::check())
				{
					$userPower = Auth::user()->group->power;

					$query->orWhere('required_power', '<=', $userPower);
					$query->where('required_power', '!=', 0);
				}

				// If the user is logged out, take all links that require
				// a logged out user.
				else
				{
					$query->orWhere('required_power', 0);
				}

			}))->where('slug', '=', $group)->first();

			if( ! is_null($group))
			{
				foreach($group->links as $link)
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
			}
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