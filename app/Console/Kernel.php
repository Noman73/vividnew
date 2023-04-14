<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('add:bonus')->dailyAt('23:30');
        $schedule->command('club:initClubBonus')->dailyAt('20:00');
        $schedule->command('club:level1')->dailyAt('20:30');
        $schedule->command('club:level2')->dailyAt('21:00');
        $schedule->command('club:level3')->dailyAt('21:30');
        $schedule->command('test:cron')->everyMinute();
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
