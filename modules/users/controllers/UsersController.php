<?php

class UsersController extends Controller {

	/**
	 * Get the user's profile.
	 *
	 * @return void
	 */
	public function getProfile()
	{
		$this->page->addBreadcrumb('Profile');

		$this->page->setContent('users::profile');
	}

	/**
	 * Show the login form.
	 *
	 * @return void
	 */
	public function getLogin()
	{
		$this->page->addBreadcrumb('Login');

		$this->page->setContent('users::login');
	}

	/**
	 * Log the user in.
	 *
	 * @return RedirectResponse
	 */
	public function postLogin()
	{
		$form = Validator::make(Input::all(), array(
			'email'    => array('required', 'email'),
			'password' => array('required'),
		));

		if($form->passes())
		{
			$credentials = array(
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
			);

			if(Auth::attempt($credentials))
			{
				return Redirect::to('users/profile');
			}

			else
			{
				$errors = new MessageBag(array(
					'login' => 'Invalid credentials.',
				));
			}
		}

		else
		{
			$errors = $form->messages();
		}

		return Redirect::to('users/login')
				->withInput()
				->withErrors($errors);
	}

	/**
	 * Log the user out.
	 *
	 * @return RedirectResponse
	 */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('login');
	}
}