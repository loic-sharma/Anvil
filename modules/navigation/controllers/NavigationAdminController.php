<?php

class NavigationAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Navigation');

		$this->page->setContent('navigation::admin.home');
	}

	public function getAddMenu()
	{
		$menu = new Navigation\Menu;

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Add Menu');

		$this->page->setContent('navigation::admin.menu', compact('menu'));
	}

	public function postAddMenu()
	{
		$menu = new Navigation\Menu;

		$menu->title = Input::get('title');
		$menu->slug = Input::get('slug');

		if($menu->save())
		{
			Cache::flush();

			return Redirect::to('admin/navigation/menu/'.$menu->slug)
				->with('menu', 'Successfully created menu.');
		}

		else
		{
			return Redirect::back()->withInput()->withErrors($menu->errors());
		}
	}

	public function getMenu($menu)
	{
		$links = Navigation\Menu::with('links')
			->where('slug', $menu)
			->first()->links;

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Menu');

		$this->page->setContent('navigation::admin.links', compact('menu', 'links'));
	}

	public function getDeleteMenu($menu)
	{
		$links = Navigation\Menu::where('slug', $menu)->first();

		if(  ! is_null($links))
		{
			$links->delete();

			Cache::flush();
		}

		return Redirect::to('admin/navigation')
			->with('message', 'Sucessfully deleted menu.');
	}

	public function getCreateLink($menu)
	{
		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Menu', 'admin/navigation/menu/'.$menu.'/edit');
		$this->page->addBreadcrumb('Add Link');

		$link = new Navigation\Link;

		$this->page->setContent('navigation::admin.link', compact('link'));
	}

	public function postCreateLink($slug)
	{
		$menu = Navigation\Menu::where('slug', $slug)->first();

		if( ! is_null($menu))
		{
			$link = new Navigation\Link;

			$link->menu_id = $menu->id;
			$link->title = Input::get('title');
			$link->url = Input::get('url');
			$link->required_power = Input::get('required_power', NULL);

			if($link->save())
			{
				Cache::flush();

				return Redirect::to('admin/navigation/menu/'.$slug)
					->with('message', 'Successfully created link.');
			}

			else
			{
				$errors = $link->errors();
			}
		}

		else
		{
			$errors = new MessageBag(array(
				'menu' => 'Menu does not exist.',
			));
		}

		return Redirect::back()->withErrors($errors);
	}

	public function getEditLink($id)
	{
		$link = Navigation\Link::find($id);

		if(is_null($link))
		{
			return Redirect::back();
		}

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Menu', 'admin/navigation/menu/'.$link->menu->slug);
		$this->page->addBreadcrumb('Edit Link');

		$this->page->setContent('navigation::admin.link', compact('link'));
	}

	public function postEditLink($id)
	{
		$link = Navigation\Link::find($id);

		if( ! is_null($link))
		{
			$link->title = Input::get('title');
			$link->url = Input::get('url');
			$link->required_power = Input::get('required_power', NULL);

			if($link->save())
			{
				Cache::flush();

				return Redirect::to('admin/navigation/link/'.$id.'/edit')
					->with('message', 'Sucessfully edited link.');
			}

			else
			{
				$errors = $link->errors();
			}
		}

		else
		{
			$errors = new MessageBag(array(
				'link' => 'Link does not exist.',
			));
		}

		return Redirect::to('admin/navigation/link/'.$id.'/edit')
			->withInput()
			->withErrors($errors);
	}

	public function getDeleteLink($menu, $id)
	{
		$link = Navigation\Link::find($id);

		if( ! is_null($link))
		{
			Cache::flush();

			$link->delete();
		}

		return Redirect::to('admin/navigation/menu/'.$menu)
			->with('message', 'Sucessfully deleted link.');
	}
}