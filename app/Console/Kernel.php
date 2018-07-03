<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        

        //tests
        $schedule->command('testSchedule:new "10 min test"')
                 ->everyTenMinutes();
        $schedule->command("testSchedule:new 'Daily test'")->daily();

        // import daily sales
        $dt = Carbon::now();
        $yesterday = $dt->subDay()->toDateString();
        $schedule->command("import:sales $yesterday 30")->dailyAt('06:10');
        $schedule->command("calculate:total $yesterday")->dailyAt('06:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
