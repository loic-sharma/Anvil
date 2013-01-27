<?php

class GroupsAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Groups');

		$this->page->setContent('users::admin.groups.home');
	}

	public function getCreate()
	{
		$editing = false;
		$group = new Group;

		$this->page->addBreadcrumb('Groups', 'admin/groups');
		$this->page->addBreadcrumb('Create Group');

		$this->page->setContent('users::admin.groups.group', compact('editing', 'group'));
	}

	public function postCreate()
	{
		$group = new Group;

		$group->name = Input::get('name');
		$group->power = Input::get('power');

		if($group->save())
		{
			return Redirect::to('admin/group/'.$group->id.'/edit');
		}

		else
		{
			return Redirect::back()->withInput()->withErrors($group);
		}
	}

	public function getEdit($id)
	{
		$editing = true;
		$group = Group::find($id);

		$this->page->addBreadcrumb('Groups', 'admin/groups');
		$this->page->addBreadcrumb('Edit Group');

		$this->page->setContent('users::admin.groups.group', compact('editing', 'group'));
	}

	public function postEdit($id)
	{
		$group = Group::find($id);

		if( ! is_null($group))
		{
			$group->name = Input::get('name');
			$group->power = Input::get('power');

			if($group->save())
			{
				return Redirect::to('admin/group/'.$group->id.'/edit');
			}

			else
			{
				$errors = $group->errors();
			}
		}

		else
		{
			$errors = new MessageBag(array(
				'group' => 'Group does not exist.',
			));
		}

		return Redirect::back()->withInput()->withErrors($errors);
	}

	public function getDelete($id)
	{
		$group = Group::find($id);

		if( ! is_null($group))
		{
			$group->delete();
		}

		return Redirect::back();
	}
}