<?php

namespace App\Console;

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
        Commands\GetTweets::class,
        Commands\MailSend::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // GetTweets 1時間おきに実行
        $schedule
                ->command('batch:GetTweets --table_name=keywords_search_tweets')
                //->hourly();
                ->hourlyAt(10);
        
        // MailSend 1日おきに実行
        $schedule
                ->command('command:MailSend --search_word=じゃらん --base_date='.date('Ymd', strtotime('-1 day')))
                ->dailyAt('00:10');
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
