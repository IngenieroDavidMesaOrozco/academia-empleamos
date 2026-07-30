<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\EnviarAlertasRecordatorios::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Aquí registramos la tarea
      //  $schedule->command('recordatorios:alertas')->dailyAt('22:00');
      
      
       // Para prueba rápida: ejecuta cada minuto
    //$schedule->command('recordatorios:alertas')->everyMinute();
    
    
     // Ejecuta el comando cada hora en punto
    $schedule->command('recordatorios:alertas')->hourly();
    
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
