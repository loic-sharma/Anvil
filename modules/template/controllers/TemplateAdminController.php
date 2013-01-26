<?php

class TemplateAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Templates');

		$this->page->setContent('template::admin.home');
	}

	public function postIndex()
	{
		$form = Validator::make(Input::all(), array(
			'template' => 'required',
		));

		if($form->passes())
		{
			$templates = Plugins::get('templates')->get();

			// Make sure that the template actually exists;
			foreach($templates as $template)
			{
				if($template->slug == Input::get('template'))
				{
					Settings::set('template', $template->slug);

					return Redirect::back();
				}
			}

			$errors = new MessageBag(array(
				'template' => 'Template does not exist.',
			));
		}

		else
		{
			$errors = $form->errors();
		}

		return Redirect::back()->withInput()->withError($errors);
	}
}