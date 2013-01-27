<?php

class SettingsAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Settings');

		$this->page->setcontent('settings::admin.home');
	}

	public function postIndex()
	{
		$form = Validator::make(Input::all(), array(
			'title'    => 'required',
		));

		if($form->passes())
		{
			Settings::set('title', Input::get('title'));

			return Redirect::to('admin/settings');
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::back()->withErrors($errors);
	}
}