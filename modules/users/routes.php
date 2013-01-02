<?php

class UsersController extends Controller {

	public function getLogin()
	{
		$this->page->content = View::make('users::login');
	}

	public function postLogin()
	{
		$form = Validator::make(Input::all(), array(
			'email'    => array('required', 'email'),
			'password' => array('required'),
		));

		if($form->passes())
		{
			$user = array(
				'username' => Input::get('email'),
				'password' => Input::get('password'),
			);

			if(Auth::attempt($user))
			{
				die('success');
			//	return Redirect::to('users/profile');
			}

			else
			{
				$form->getMessages()->add('email', 'Invalid username and password combination.');
			}
		}

		Input::flash();

		return Redirect::to('users/login')->withErrors($form->getMessages());
	}
}