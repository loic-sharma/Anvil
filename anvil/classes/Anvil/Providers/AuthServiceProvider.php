<?php namespace Anvil\Providers;

use Anvil\Auth\AuthManager;

use Illuminate\Auth\AuthServiceProvider as IlluminateAuthServiceProvider;

class AuthServiceProvider extends IlluminateAuthServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['auth'] = $this->app->share(function($app)
		{
			// Once the authentication service has actually been requested by the developer
			// we will set a variable in the application indicating such. This helps us
			// know that we need to set any queued cookies in the after event later.
			$app['auth.loaded'] = true;

			return new AuthManager($app);
		});
	}
}