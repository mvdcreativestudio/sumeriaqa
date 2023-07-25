<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        
        // Agregar la tarea programada "orden:actualizar-estado" cada 30 segundos
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('orden:actualizar-estado')->daily();
        });
        
        $this->app->booted(function () {
            require base_path('routes/console.php');
        });
    }
}
