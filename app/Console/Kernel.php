<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\UpdateStatusPrakerin;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(UpdateStatusPrakerin::class)->dailyAt('00:10');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}

