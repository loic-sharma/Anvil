<?php

namespace Cms\Providers;

use UhOh\UhOh;
use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider {

	/**
	 * Register the UhOh Exception Handler.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['uhoh'] = new UhOh;

		$this->app['uhoh']->registerHandlers();
	}
}