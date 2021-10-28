<?php

namespace App\Console;

use App\Console\Commands\FetchMostPopularArticles;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->command(FetchMostPopularArticles::class, [FetchMostPopularArticles::EMAILED])
            ->everyMinute()->withoutOverlapping();

        $schedule->command(FetchMostPopularArticles::class, [FetchMostPopularArticles::VIEWED])
            ->everyMinute()->withoutOverlapping();

        $schedule->command(FetchMostPopularArticles::class, [FetchMostPopularArticles::SHARED])
            ->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
