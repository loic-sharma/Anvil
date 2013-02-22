<?php

class NavigationPlugin {

	/**
	 * Get all of the navigation groups.
	 *
	 * @return array
	 */
	public function groups()
	{
		return Cms\Menu\Model\Menu::all();
	}

	/**
	 * Fetch the menu to the current section.
	 *
	 * @return  string
	 */
	public function mainMenu()
	{
		if(Anvil::isAdmin())
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

		return Menu::get($name, $power)->render();
	}
}