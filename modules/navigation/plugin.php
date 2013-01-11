<?php

class NavigationPlugin extends Plugin {

	public $menus = array();

	public function links($group)
	{
		return $this->getMenu($group)->render();
	}

	protected function getMenu($group)
	{
		$menu = Menu::get($group);

		if( ! in_array($group, $this->menus))
		{
			$this->menus[] = $group;

			$group = Navigation\Group::with('links')
						->where('slug', '=', $group)
						->first();

			if( ! is_null($group))
			{
				$userPower = 0;

				if(Auth::check())
				{
					$userPower = Auth::user()->group->power;
				}

				foreach($group->links as $link)
				{
					// Check if the link has a required power.
					if( ! is_null($link->required_power))
					{
						// If the link's required power is 0, then the user must be logged out.
						if($link->required_power == 0)
						{
							if($userPower != 0)
							{
								continue;
							}
						}

						// Otherwise, the user's power must just be greater than the required
						// power.
						elseif($link->required_power >= $userPower)
						{
							continue;
						}
					}

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