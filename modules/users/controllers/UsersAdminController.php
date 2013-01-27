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

		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Create User');

		$this->page->setContent('users::admin.user', compact('editing', 'user'));
	}

	public function postCreateUser()
	{
		$user = new User;

		$user->email = Input::get('email');
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->group_id = Input::get('group');
		$user->password = Input::get('password');
		$user->password_confirmation = Input::get('password_confirmation');

		if($user->save())
		{
			return Redirect::to('admin/users/'.$user->id.'/edit');
		}

		else
		{
			$errors = $user->errors();
		}

		return Redirect::to('admin/users/create')->withInput()->withErrors($errors);
	}

	public function getEditUser($id)
	{
		$editing = true;
		$user = User::find($id);

		if(is_null($user))
		{
			return Redirect::back();
		}

		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Create User');

		$this->page->setContent('users::admin.user', compact('editing', 'user'));
	}

	public function postEditUser($id)
	{
		$user = User::find($id);

		// The password isn't required and the email
		// does not need to be unique when the user is being
		// edited.
		$user->rules['password'] = array('required');
		$user->rules['email'] = array('required');

		if( ! is_null($user))
		{
			$user->email = Input::get('email');
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->group_id = Input::get('group');

			// Only save the password if one is inputted.
			if(Input::get('password') != '')
			{
				$user->password = Input::get('password');
			}

			if($user->save())
			{
				return Redirect::to('admin/users/'.$id.'/edit');
			}

			else
			{
				$errors = $user->errors();
			}
		}

		return Redirect::to('admin/users/'.$id.'/edit')->withInput()->withErrors($errors);
	}

	public function getDeleteUser($id)
	{
		$user = User::find($id);

		if( ! is_null($user))
		{
			$user->delete();
		}

		return Redirect::to('admin/users');
	}

	public function getGroups()
	{
		$this->page->addBreadcrumb('Users', 'admin/users');
		$this->page->addBreadcrumb('Groups');

		$this->page->setContent('users::admin.groups');
	}
}