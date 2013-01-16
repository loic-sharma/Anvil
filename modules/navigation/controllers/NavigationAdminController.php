<?php

use Navigation\Group;
use Navigation\Link;

class NavigationAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Navigation');

		$this->page->setContent('navigation::admin.home');
	}

	public function getMenu($menu)
	{
		$this->page->addBreadcrumb('Navigation', 'admin/navigation');
		$this->page->addBreadcrumb('Menu');

		$this->page->setContent('navigation::admin.menu', compact('menu'));
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

				return Redirect::to('admin/navigation/menu/'.$slug.'/add-link');
			}

			else
			{
				$errors = new MessageBag;

				$errors->add('menu', 'Menu does not exist.');
			}
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::back()->withErrors($errors);
	}
}