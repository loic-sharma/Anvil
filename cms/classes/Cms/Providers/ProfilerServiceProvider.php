<?php namespace Cms\Providers;

use Profiler\Profiler;
use Profiler\Logger\Logger;
use Profiler\ProfilerServiceProvider as BaseProfilerServiceProvider;

class ProfilerServiceProvider extends BaseProfilerServiceProvider {

	/**
	 * Register the profiler.
	 *
	 * @return void
	 */
	public function registerProfiler()
	{	
		$this->app['profiler'] = $this->app->share(function($app)
		{
			return new Profiler(new Logger, CMS_START);
		});
	}
}