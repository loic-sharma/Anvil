<?php

class ThemeAdminController extends Controller {

	public function getIndex()
	{
		$this->page->addBreadcrumb('Themes');

		$this->page->setContent('theme::admin.home');
	}

	public function postIndex()
	{
		$form = Validator::make(Input::all(), array(
			'theme' => 'required',
		));

		if($form->passes())
		{
			$themes = Plugins::get('themes')->get();

			// Make sure that the theme actually exists
			foreach($themes as $theme)
			{
				if($theme->slug == Input::get('theme'))
				{
					Settings::set('theme', $theme->slug);

					return Redirect::back();
				}
			}

			$errors = new MessageBag(array(
				'theme' => 'Theme does not exist.',
			));
		}

		else
		{
			$errors = $form->errors();
		}

		return Redirect::back()->withInput()->withError($errors);
	}

	public function getPreview($theme)
	{
		if(Plugins::get('themes')->exists($theme))
		{
			app()->setTheme($theme);	

			$this->page->content = 'This is a preview.';
		}

		else
		{
			$error = new MessageBag(array(
				'theme' => 'Theme does not exist.',
			));

			return Redirect::back()->withError($error);
		}
	}

	public function getDelete($theme)
	{

	}
}