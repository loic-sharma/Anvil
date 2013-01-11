<?php

class UsersController extends Controller {

	public function __construct()
	{
		$this->beforeFilter('logged_in', array(
			'only' => array('getProfile'),
		));

		$this->beforeFilter('logged_out', array(
			'only' => array('getLogin', 'postLogin')
		));
	}

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

			try
			{
				if(Sentry::authenticate($credentials))
				{
					return Redirect::to('users/profile');
				}

				else
				{
					$form->addError('email', 'Failed authentication.');
				}
			}

			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				$form->addError('email', 'Invalid username and password combination');
			}

			// These should never happen with the validation.
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {}
			catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {}

			catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
			{
				$form->addError('email', 'User suspended.');
			}

			catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
			{
				$form->addError('email', 'User banned.');
			}
		}

		Input::flash();

		return Redirect::to('users/login')->withErrors($form->messages());
	}

	/**
	 * Log the user out.
	 *
	 * @return RedirectResponse
	 */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('users/login');
	}
}