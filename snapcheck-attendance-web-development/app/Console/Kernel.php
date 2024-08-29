<?php

namespace App\Console;

use App\Http\Controllers\Backend\AttendanceController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('app:set-expire-attendance')->everyFiveMinutes();
         $schedule->command('app:set-absent-student')->everyTenMinutes();
        /*$schedule->call(function () {
            // Call the method to delete users
            AttendanceController::setExpired(); // replace YourController with the actual controller name
        })->everyMinute();*/
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
