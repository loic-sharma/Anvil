<?php

use Navigation\Group;
use Navigation\Link;

class NavigationAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Navigation');

		$this->page->setContent('navigation::admin.home');
	}

	public function getAddMenu()
	{
		$editing = false;
		$menu = new Group;

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Add Menu');

		$this->page->setContent('navigation::admin.menu', compact('editing', 'menu'));
	}

	public function postAddMenu()
	{
		$menu = new Group;

		$menu->title = Input::get('title');
		$menu->slug = Input::get('slug');

		if($menu->save())
		{
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
		$links = Group::with('links')
			->where('slug', $menu)
			->first()->links;

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Menu');

		$this->page->setContent('navigation::admin.links', compact('menu', 'links'));
	}

	public function getDeleteMenu($menu)
	{
		$links = Group::where('slug', $menu)->first();

		if(  ! is_null($links))
		{
			$links->delete();
		}

		return Redirect::to('admin/navigation')
			->with('message', 'Sucessfully deleted menu.');
	}

	public function getCreateLink($menu)
	{
		$editing = false;

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Group', 'admin/navigation/menu/'.$menu.'/edit');
		$this->page->addBreadcrumb('Add Link');

		$link = new Link;

		$this->page->setContent('navigation::admin.link', compact('editing', 'link'));
	}

	public function postCreateLink($slug)
	{
		$form = Validator::make(Input::all(), array(
			'title' => array('required'),
			'url' => array('required', 'url'),
			'required_power' => array('numeric'),
		));

		if($form->passes())
		{
			$menu = Group::where('slug', $slug)->first();

			if( ! is_null($menu))
			{
				$link = new Link;

				$link->group_id = $menu->id;
				$link->title = Input::get('title');
				$link->url = Input::get('url');
				$link->required_power = Input::get('required_power', NULL);

				$link->save();

				return Redirect::to('admin/navigation/menu/'.$slug)
					->with('message', 'Successfully created link.');
			}

			else
			{
				$errors = new MessageBag(array(
					'menu' => 'Menu does not exist.',
				));
			}
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::back()->withErrors($errors);
	}

	public function getEditLink($id)
	{
		$editing = true;
		$link = Link::find($id);

		if(is_null($link))
		{
			return Redirect::back();
		}

		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Menu', 'admin/navigation/menu/'.$link->group->slug);
		$this->page->addBreadcrumb('Edit Link');

		$this->page->setContent('navigation::admin.link', compact('editing', 'link'));
	}

	public function postEditLink($id)
	{
		$link = Link::find($id);

		if( ! is_null($link))
		{
			$link->title = Input::get('title');
			$link->url = Input::get('url');
			$link->required_power = Input::get('required_power', NULL);

			if($link->save())
			{
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
		$link = Link::find($id);

		if( ! is_null($link))
		{
			$link->delete();
		}

		return Redirect::to('admin/navigation/menu/'.$menu)
			->with('message', 'Sucessfully deleted link.');
	}
}