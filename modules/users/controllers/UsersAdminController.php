<?php

class UsersAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Users');

		$this->page->setContent('users::admin.home');
	}

	public function getCreateUser()
	{
		$editing = false;
		$user = new User;
		$groups = array();

		foreach(Group::all() as $group)
		{
			$groups[$group->id] = $group->name;
		}

		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Create User');

		$this->page->setContent('users::admin.user', compact('editing', 'user', 'groups'));
	}

	public function postCreateUser()
	{
		$form = Validator::make(Input::all(), array(
			'email' => array('required', 'email'),
			'password' => array('required', 'confirmed'),
			'first_name' => array('alpha_dash'),
			'last_name' => array('alpha_dash'),
			'group' => array('required', 'numeric'),
		));

		if($form->passes())
		{
			$user = new User;

			$user->email = Input::get('email');
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->group_id = Input::get('group');
			$user->password = Input::get('password');

			$user->save();

			return Redirect::to('admin/users/'.$user->id.'/edit');
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::to('admin/users/create')->withErrors($errors);
	}

	public function getEditUser($id)
	{
		$editing = true;
		$user = User::find($id);

		if(is_null($user))
		{
			return Redirect::back();
		}

		$groups = array();

		foreach(Group::all() as $group)
		{
			$groups[$group->id] = $group->name;
		}

		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Create User');

		$this->page->setContent('users::admin.user', compact('editing', 'user', 'groups'));
	}

	public function postEditUser($id)
	{
		$form = Validator::make(Input::all(), array(
			'email' => array('required', 'email'),
			'password' => array('confirmed'),
			'first_name' => array('alpha_dash'),
			'last_name' => array('alpha_dash'),
			'group' => array('required', 'numeric'),
		));

		if($form->passes())
		{
			$user = User::find($id);

			if( ! is_null($user))
			{
				$user->email = Input::get('email');
				$user->first_name = Input::get('first_name');
				$user->last_name = Input::get('last_name');
				$user->group_id = Input::get('group');

				if(Input::get('password') != '')
				{
					$user->password = Input::get('password');
				}

				$user->save();

				return Redirect::to('admin/users/'.$id.'/edit');
			}

			else
			{
				$errors = new MessageBag;

				$errors->add('user', 'User does not exist.');
			}
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::to('admin/users/'.$id.'/edit')->withErrors($errors);
	}

	public function getGroups()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Groups');

		$this->page->setContent('users::admin.groups');
	}

	public function getPermissions()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Permissions');

		$this->page->setContent('users::admin.permissions');
	}
}