<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\AppFormSession;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();   
        // $schedule->command('inspire')
        // ->daily()
        // ->before(function () {
           
        //    $newAppFormSession = new AppFormSession;
   
        //        $newAppFormSession->user_id = '3';
        //        $newAppFormSession->user_name = 'bruh';
        //        $newAppFormSession->is_alive = true;
   
        //        $newAppFormSession->save();
        // })
        // ->after(function () {
        //     // The task has executed...
        // });
        $schedule->call(function () {
            $newAppFormSession = new AppFormSession;
    
                $newAppFormSession->user_id = '3';
                $newAppFormSession->user_name = 'bruh';
                $newAppFormSession->is_alive = true;
    
                $newAppFormSession->save();

        })->everyMinute();
    }

    protected function scheduleAppForm(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('emails:send')
         ->daily()
         ->before(function () {
            
            $newAppFormSession = new AppFormSession;
    
                $newAppFormSession->user_id = '3';
                $newAppFormSession->user_name = 'bruh';
                $newAppFormSession->is_alive = true;
    
                $newAppFormSession->save();
         })
         ->after(function () {
             // The task has executed...
         });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
