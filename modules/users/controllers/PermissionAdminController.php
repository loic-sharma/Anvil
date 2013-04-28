<?php

class PermissionAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Users')->to('admin/users');
		$this->page->addBreadcrumb('Permissions');

		$this->page->setContent('users::admin.permissions');

	}

	public function getEditPermission($id)
	{
		$permission = Permission::find($id);

		if(is_null($permission))
		{
			return Redirect::to('admin/permissions');
		}

		$this->page->addBreadcrumb('Permissions')->to('admin/permissions');
		$this->page->addBreadcrumb('Permission');

		$this->page->setContent('users::admin.permission', compact('permission'));
	}

	public function postEditPermission($id)
	{
		$permission = Permission::find($id);

		if( ! is_null($permission))
		{
			$permission->name = Input::get('name');
			$permission->slug = Input::get('slug');

			// We only want to set the power requiredments if there
			// are power requirements. Otherwise, leave them null.
			foreach(array('required_power', 'max_power') as $input)
			{
				if(Input::get($input, false) !== false and Input::get($input) != '')
				{
					$permission->$input = Input::get($input);
				}
			}

			if($permission->save())
			{
				return Redirect::to('admin/permission/'.$id.'/edit')
						->with('message', 'Successfully created permission.');
			}

			else
			{
				$errors = $permission->errors();
			}
		}

		else
		{
			$errors = new MessageBag(array(
				'permission' => 'Permission does not exist.',
			));
		}

		return Redirect::to('admin/permission/'.$id.'/edit')->withInput()->withErrors($errors);
	}
}