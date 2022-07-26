<?php

namespace App\Console;

use App\Console\Commands\BackUpData;
use App\Console\Commands\DatabaseBackUp;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    protected $commands = [
        //
        DatabaseBackUp::class,
        // BackUpData::class,
    ];

    protected function schedule(Schedule $schedule) {
        // $schedule->command('backup:run')->everyMinute();
        $schedule->command('database:backup')->everyMinute();
        // $schedule->command('inspire')->hourly();
        // $schedule->command('data:store')->everyMinute();
    }


    protected function commands() {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
