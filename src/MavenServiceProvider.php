<?php namespace Sukohi\Maven;

use Illuminate\Support\ServiceProvider;

class MavenServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/views', 'maven');

		$this->publishes([
			__DIR__.'/migrations' => database_path('migrations')
		], 'migrations');

		$this->loadTranslationsFrom(__DIR__.'translations', 'maven');
		$this->publishes([
			__DIR__.'/translations' => base_path('resources/lang/vendor/maven'),
		], 'translations');

		$this->app->singleton('command.maven:export', function ($app) {

			return $app['Sukohi\Maven\Commands\MavenExportCommand'];

		});
		$this->commands('command.maven:export');
		$this->app->singleton('command.maven:import', function ($app) {

			return $app['Sukohi\Maven\Commands\MavenImportCommand'];

		});
		$this->commands('command.maven:import');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['maven'] = $this->app->share(function($app)
		{
			return new Maven;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['maven'];
	}

}