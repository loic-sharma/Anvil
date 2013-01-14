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
			'template' => 'required',
		));

		if($form->passes())
		{
			return Redirect::to('admin/settings');
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::back()->withErrors($errors);
	}
}