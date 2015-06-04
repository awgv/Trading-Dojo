<?php namespace Dojo\Providers;

use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app['validator']->extend('alpha_num_spaces', function($attribute, $value, $parameters)
		{
			return preg_match('/(^[A-Za-z0-9 \']+$)+/', $value);
		});

		$this->app['validator']->extend('alpha_num_dots', function($attribute, $value, $parameters)
		{
			return preg_match('/^[a-zA-Z0-9-_.]+$/', $value);
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
