<?php namespace Anvil\Plugins;

use Anvil\Auth\Models\User;
use Anvil\Menu\Models\Menu as MenuModel;
use Anvil\Menu\Menu as MenuGenerator;

class NavigationPlugin {

	/**
	 * The current user's model.
	 *
	 * @var Anvil\Auth\Models\User
	 */
	protected $currentUser;

	/**
	 * The menu's model.
	 *
	 * @var Anvil\Menu\Model\Menu
	 */
	protected $menu;

	/**
	 * The menu generator used to render menus.
	 *
	 * @var Menu\Factory
	 */
	protected $generator;

	/**
	 * Register the dependencies.
	 *
	 * @param  Anvil\Auth\Models\User  $currentuser
	 * @param  Anvil\Menu\Model\Menu   $menu
	 * @param  Anvil\Menu\Menu         $generator
	 * @return void
	 */
	public function __construct(User $currentUser, MenuModel $menu, MenuGenerator $generator)
	{
		$this->currentUser = $currentUser;
		$this->menu = $menu;
		$this->generator = $generator;
	}

	/**
	 * Get all of the navigation groups.
	 *
	 * @return array
	 */
	public function groups()
	{
		return $this->model->all();
	}

	/**
	 * Display a menu.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function menu($name)
	{
		$menu = $this->generator->get($name, $this->currentUser->power);

		return $menu->render();
	}
}