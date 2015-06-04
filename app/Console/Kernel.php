<?php namespace Dojo\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'Dojo\Console\Commands\Inspire',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule
			->call('Dojo\Http\Controllers\OfferController@scheduledRemoval')
			->dailyAt('09:00');

		$schedule
			->call('Dojo\Http\Controllers\AccountController@scheduledStatusSwitcher')
			->hourly();
	}

}
