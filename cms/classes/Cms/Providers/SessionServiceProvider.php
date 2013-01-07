<?php

namespace Cms\Providers;

use Illuminate\Session\SessionServiceProvider as IlluminateSessionServiceProvider;

class SessionServiceProvider extends IlluminateSessionServiceProvider {

	/**
	 * Register the events needed for session management.
	 *
	 * @return void
	 */
	public function registerSessionEvents()
	{
		$app = $this->app;

		$config = $app['config']['session'];

		// The session needs to be started and closed, so we will register a before
		// and after events to do all stuff for us. This will manage the loading
		// the session "payloads", as well as writing them after each request.
		if ( ! is_null($config['driver']))
		{
			$app->close(function($request, $response) use ($app, $config)
			{
				$app['session']->finish($response, $app['cookie'], $config['lifetime']);
			});
		}
	}
}