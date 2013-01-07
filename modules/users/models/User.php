<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser {

	public function displayName()
	{
		return $this->attributes['first_name'].' '.$this->attributes['last_name'];
	}

	public function gravatarUrl($size = 60)
	{
		$url  = 'http://www.gravatar.com/avatar/';
		$url .= md5(strtolower($this->attributes['email']));
		$url .= '?s='.$size;

		return $url;
	}

	public function gravatar($size = 60)
	{
		$url = $this->gravatarUrl($size);

		return '<img src="'.$url.'" alt="Gravatar" class="gravatar" />';
	}
}